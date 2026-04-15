<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Login Type - Theos Higher Ground Academe</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.4.24/dist/full.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/2.0.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
</head>
<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen">
    <div class="container mx-auto px-4 py-8 min-h-screen flex items-center justify-center">
        <div class="w-full max-w-4xl">
            <!-- Header -->
            <div class="text-center mb-8">
                <img src="{{ asset('logo-modified.png') }}" alt="School Logo" class="w-20 h-20 mx-auto mb-4">
                <h1 class="text-3xl font-bold text-blue-900 mb-2">Theos Higher Ground Academe</h1>
                <p class="text-gray-600">Select your login type to continue</p>
            </div>

            <!-- Login Type Selection -->
            <div class="mt-6">
                <h2 class="text-xl font-bold text-center text-gray-800 mb-2">Select Login Type</h2>
                <p class="text-sm text-center text-gray-600 mb-6">Choose how you want to access the system</p>

                <!-- Login Type Cards -->
                <div class="space-y-4">
                    <!-- Student Login Card -->
                    <a href="{{ route('login', ['type' => 'student']) }}"
                       class="group block p-4 bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 rounded-lg border-2 border-blue-200 hover:border-blue-400 transition-all duration-300 transform hover:scale-105">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0 group-hover:bg-blue-700 transition-colors">
                                <i class="fi fi-rr-graduation-cap text-xl text-white"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-800 group-hover:text-blue-700">Student Login</h3>
                                <p class="text-xs text-gray-600">Access grades, assignments, and student portal</p>
                            </div>
                            <i class="fi fi-rr-arrow-right text-blue-600 group-hover:text-blue-700 transform group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </a>

                    <!-- Employee Login Card -->
                    <a href="{{ route('login', ['type' => 'employee']) }}"
                       class="group block p-4 bg-gradient-to-r from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 rounded-lg border-2 border-green-200 hover:border-green-400 transition-all duration-300 transform hover:scale-105">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center flex-shrink-0 group-hover:bg-green-700 transition-colors">
                                <i class="fi fi-rr-briefcase text-xl text-white"></i>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-gray-800 group-hover:text-green-700">Employee Login</h3>
                                <p class="text-xs text-gray-600">Access admin tools, staff portal, and resources</p>
                            </div>
                            <i class="fi fi-rr-arrow-right text-green-600 group-hover:text-green-700 transform group-hover:translate-x-1 transition-transform"></i>
                        </div>
                    </a>
                </div>

                <!-- Back to Home Link -->
                <div class="mt-6 text-center">
                    <a href="{{ route('landing') }}" class="text-sm text-gray-600 hover:text-accent hover:underline inline-flex items-center gap-2">
                        <i class="fi fi-rr-arrow-left"></i>
                        <span>Back to Home</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
