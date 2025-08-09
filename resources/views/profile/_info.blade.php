<div class="bg-gray-50 p-4 rounded-lg border-0 flex flex-col sm:flex-row items-start sm:items-center">
    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full object-cover border-4 border-sky-400 mr-6 mb-4 sm:mb-0">
    <div>
        <p class="text-lg font-semibold text-gray-900">{{ __('profile.username') }}: <span class="font-normal">{{ $user->name }}</span></p>
        <p class="text-md text-gray-600 mb-1">{{ __('profile.user_id') }}: <span class="font-mono text-gray-800">{{ $user->id }}</span></p>
        <p class="text-md text-gray-600 mb-1">{{ __('profile.discord_id') }}: <span class="font-mono text-gray-800">{{ $user->discord_id }}</span></p>
        <p class="text-md text-gray-600 transition-all duration-300">
            {{ __('profile.email') }}: <span
                :class="{ 'filter blur-sm': !emailHover }"
                @mouseenter="emailHover = true"
                @mouseleave="emailHover = false">
                {{ $user->email }}
            </span>
        </p>
        <p class="text-md text-gray-600 mt-2">{{ __('profile.account_created') }}: {{ $user->created_at->format('M d, Y H:i') }}</p>
    </div>
</div>
