<?php

namespace App\Http\Controllers;

use App\Models\HealthcareProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator; 

class HealthcareProviderController extends Controller
{
    /**
     * Display the registration form
     */
    public function index()
    {
        return view('welcome');
    }

    /**
     * Store a newly created healthcare provider
     */
    public function store(Request $request)
    {
        Log::info('Received healthcare provider registration request', [
            'data' => $request->all()
        ]);

        try {
            // Validate the request
            $validated = $request->validate([
                'organization_name' => 'required|string|max:255',
                'facility_type' => 'required|string',
                'other_facility_type' => 'required_if:facility_type,other',
                'ownership_type' => 'required|string',
                'other_ownership_type' => 'required_if:ownership_type,other',
                'email_address' => 'required|email',
                'phone_number' => 'required|string',
                'country' => 'required|string',
                'state' => 'required|string',
                'city' => 'required|string',
                'zipcode' => 'required|string',
                'google_map_link' => 'nullable|url',
                'is_ae_available' => 'required|boolean',
                'is_24hours' => 'required|boolean',
                'operating_hours' => 'nullable|array|required_if:is_24hours,0'
            ]);

            Log::info('Validation passed', [
                'validated_data' => $validated
            ]);

            DB::beginTransaction();

            // Create the healthcare provider
            $provider = HealthcareProvider::create($validated);
            
            Log::info('Healthcare provider created', [
                'provider_id' => $provider->id,
                'provider_data' => $provider->toArray()
            ]);

            // Handle operating hours if not 24 hours
            if (!$request->is_24hours && $request->operating_hours) {
                $operatingHours = [];
                foreach ($request->operating_hours as $day => $hours) {
                    $operatingHour = $provider->operatingHours()->create([
                        'day' => $day,
                        'start_time' => $hours['start_time'],
                        'end_time' => $hours['end_time']
                    ]);
                    $operatingHours[] = $operatingHour->toArray();
                }
                
                Log::info('Operating hours created', [
                    'provider_id' => $provider->id,
                    'operating_hours' => $operatingHours
                ]);
            }

            DB::commit();
            Log::info('Transaction committed successfully');

            return response()->json([
                'status' => 'success',
                'message' => 'Healthcare provider registered successfully',
                'data' => [
                    'provider' => $provider->toArray(),
                    'operating_hours' => $provider->operatingHours->toArray()
                ]
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed', [
                'errors' => $e->errors()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Healthcare Provider Registration Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Registration failed',
                'debug_message' => $e->getMessage() // Remove this in production
            ], 500);
        }
    }

  
    
    /**
     * Handle bulk upload of healthcare providers
     */
    public function bulkStore(Request $request)
{
    Log::info('Received bulk upload request', [
        'data' => $request->all()
    ]);

    try {
        // Validate the request structure
        if (!$request->has('providers')) {
            throw new \Exception('No providers data received');
        }

        $providers = $request->input('providers');
        
        if (!is_array($providers)) {
            throw new \Exception('Invalid data format. Expected array of providers.');
        }

        Log::info('Processing providers', [
            'count' => count($providers),
            'first_provider' => isset($providers[0]) ? $providers[0] : null
        ]);

        DB::beginTransaction();

        $results = [
            'success' => 0,
            'failed' => 0,
            'errors' => []
        ];

        foreach ($providers as $index => $providerData) {
            try {
                Log::info('Processing provider row ' . ($index + 1), [
                    'data' => $providerData
                ]);

                // Validate each provider
                $validator = Validator::make($providerData, [
                    'organization_name' => 'required|string|max:255',
                    'facility_type' => 'required|string',
                    'other_facility_type' => 'required_if:facility_type,other',
                    'ownership_type' => 'required|string',
                    'other_ownership_type' => 'required_if:ownership_type,other',
                    'email_address' => 'required|email',
                    'phone_number' => 'required|string',
                    'country' => 'required|string',
                    'state' => 'required|string',
                    'city' => 'required|string',
                    'zipcode' => 'required|string',
                    'google_map_link' => 'nullable|url',
                    'is_ae_available' => 'required|boolean',
                    'is_24hours' => 'required|boolean',
                    'operating_hours' => 'nullable|array'
                ]);

                if ($validator->fails()) {
                    Log::warning('Validation failed for row ' . ($index + 1), [
                        'errors' => $validator->errors()->toArray()
                    ]);

                    $results['failed']++;
                    $results['errors'][] = [
                        'row' => $index + 1,
                        'errors' => $validator->errors()->toArray()
                    ];
                    continue;
                }

                // Create provider
                $provider = HealthcareProvider::create($providerData);
                Log::info('Created provider', ['id' => $provider->id]);

                // Handle operating hours if present
                if (!$providerData['is_24hours'] && isset($providerData['operating_hours'])) {
                    foreach ($providerData['operating_hours'] as $day => $hours) {
                        if (isset($hours['start_time']) && isset($hours['end_time'])) {
                            $provider->operatingHours()->create([
                                'day' => $day,
                                'start_time' => $hours['start_time'],
                                'end_time' => $hours['end_time']
                            ]);
                        }
                    }
                }

                $results['success']++;

            } catch (\Exception $e) {
                Log::error('Error processing provider row ' . ($index + 1), [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                $results['failed']++;
                $results['errors'][] = [
                    'row' => $index + 1,
                    'message' => $e->getMessage()
                ];
            }
        }

        DB::commit();
        Log::info('Bulk upload completed', $results);

        return response()->json([
            'status' => 'success',
            'message' => 'Bulk upload processed',
            'results' => $results
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Bulk upload failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'status' => 'error',
            'message' => 'Bulk upload failed: ' . $e->getMessage()
        ], 500);
    }
}
}
