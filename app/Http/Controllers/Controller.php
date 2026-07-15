<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Default number of items per page for pagination.
     */
    protected int $perPage = 15;

    /**
     * Success response status code.
     */
    protected int $successStatus = 200;

    /**
     * Error response status code.
     */
    protected int $errorStatus = 400;

    /**
     * Send success response.
     */
    protected function successResponse($data = null, string $message = 'Success', int $statusCode = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Send error response.
     */
    protected function errorResponse(string $message = 'Error', int $statusCode = 400, $errors = null)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $statusCode);
    }

    /**
     * Send validation error response.
     */
    protected function validationErrorResponse($errors, string $message = 'Validation Error')
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ], 422);
    }

    /**
     * Send not found response.
     */
    protected function notFoundResponse(string $message = 'Resource not found')
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], 404);
    }

    /**
     * Send unauthorized response.
     */
    protected function unauthorizedResponse(string $message = 'Unauthorized')
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], 401);
    }

    /**
     * Send forbidden response.
     */
    protected function forbiddenResponse(string $message = 'Forbidden')
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], 403);
    }

    /**
     * Send created response.
     */
    protected function createdResponse($data = null, string $message = 'Resource created successfully')
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], 201);
    }

    /**
     * Send deleted response.
     */
    protected function deletedResponse(string $message = 'Resource deleted successfully')
    {
        return response()->json([
            'success' => true,
            'message' => $message,
        ], 200);
    }

    /**
     * Send paginated response.
     */
    protected function paginatedResponse($data, string $message = 'Success')
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data->items(),
            'pagination' => [
                'total' => $data->total(),
                'per_page' => $data->perPage(),
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'from' => $data->firstItem(),
                'to' => $data->lastItem(),
            ],
        ], 200);
    }

    /**
     * Get authenticated user.
     */
    protected function getAuthUser()
    {
        return auth()->user();
    }

    /**
     * Check if user is authenticated.
     */
    protected function isAuthenticated(): bool
    {
        return auth()->check();
    }

    /**
     * Get current user ID.
     */
    protected function getUserId(): ?int
    {
        return auth()->id();
    }

    /**
     * Flash success message to session.
     */
    protected function flashSuccess(string $message): void
    {
        session()->flash('success', $message);
    }

    /**
     * Flash error message to session.
     */
    protected function flashError(string $message): void
    {
        session()->flash('error', $message);
    }

    /**
     * Flash warning message to session.
     */
    protected function flashWarning(string $message): void
    {
        session()->flash('warning', $message);
    }

    /**
     * Flash info message to session.
     */
    protected function flashInfo(string $message): void
    {
        session()->flash('info', $message);
    }

    /**
     * Redirect back with success message.
     */
    protected function redirectBackWithSuccess(string $message)
    {
        return redirect()->back()->with('success', $message);
    }

    /**
     * Redirect back with error message.
     */
    protected function redirectBackWithError(string $message)
    {
        return redirect()->back()->with('error', $message);
    }

    /**
     * Redirect to route with success message.
     */
    protected function redirectRouteWithSuccess(string $route, string $message, $params = [])
    {
        return redirect()->route($route, $params)->with('success', $message);
    }

    /**
     * Log activity helper.
     */
    protected function logActivity(string $activity, string $description, ?int $userId = null)
    {
        if (class_exists(\App\Models\ActivityLog::class)) {
            \App\Models\ActivityLog::logActivity(
                $userId ?? auth()->id(),
                $activity,
                $description
            );
        }
    }

    /**
     * Get per page value from request.
     */
    protected function getPerPage(Request $request): int
    {
        return $request->input('per_page', $this->perPage);
    }

    /**
     * Validate and handle file upload.
     */
    protected function uploadFile($file, string $path, ?string $name = null): string
    {
        if (!$file) {
            return '';
        }

        $fileName = $name ?? time() . '_' . $file->getClientOriginalName();
        return $file->storeAs($path, $fileName, 'public');
    }

    /**
     * Delete file from storage.
     */
    protected function deleteFile(?string $path): bool
    {
        if (!$path) {
            return false;
        }

        if (\Storage::disk('public')->exists($path)) {
            return \Storage::disk('public')->delete($path);
        }

        return false;
    }

    /**
     * Get full URL for file.
     */
    protected function getFileUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        return \Storage::disk('public')->url($path);
    }

    /**
     * Generate random string.
     */
    protected function generateRandomString(int $length = 10): string
    {
        return \Str::random($length);
    }

    /**
     * Generate slug from string.
     */
    protected function generateSlug(string $string): string
    {
        return \Str::slug($string);
    }

    /**
     * Check if request is AJAX or wants JSON.
     */
    protected function expectsJson(Request $request): bool
    {
        return $request->expectsJson() || $request->isJson() || $request->ajax();
    }
}
