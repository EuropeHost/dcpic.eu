<footer class="text-center text-sm text-gray-500 mt-10 py-6 border-t">
    <p>
        &copy; {{ date('Y') }} {{ env('APP_NAME', 'DCPic.eu') }}
        by 
        <a href="https://fabianternmis.de" target="_blank" rel="noopener noreferrer" class="underline hover:text-blue-500">
            fabianternmis.de
        </a> 
        (aka 
        <a href="https://michaelninder.de" target="_blank" rel="noopener noreferrer" class="underline hover:text-blue-500">
            michaelninder.de
        </a>)
        from 
        <a href="https://europehost.eu" target="_blank" rel="noopener noreferrer" class="underline hover:text-blue-500">
            EuropeHost.eu
        </a> 
        by 
        <a href="https://xpsystems.eu" target="_blank" rel="noopener noreferrer" class="underline hover:text-blue-500">
            xpsystems.eu
        </a> 
        — All Rights Reserved.
    </p>

    <div class="flex justify-center space-x-6 mt-3 text-gray-600">
        @if(env('DISCORD_SERVER_INVITE'))
            <a href="{{ env('DISCORD_SERVER_INVITE') }}" target="_blank" rel="noopener noreferrer" class="hover:text-blue-600" aria-label="Discord Server">
                <i class="bi bi-discord text-xl"></i>
            </a>
        @endif

        @if(env('GITHUB_LINK'))
            <a href="{{ env('GITHUB_LINK') }}" target="_blank" rel="noopener noreferrer" class="hover:text-gray-800" aria-label="GitHub">
                <i class="bi bi-github text-xl"></i>
            </a>
        @endif

        @if(env('TWITTER_LINK'))
            <a href="{{ env('TWITTER_LINK') }}" target="_blank" rel="noopener noreferrer" class="hover:text-sky-500" aria-label="Twitter">
                <i class="bi bi-twitter text-xl"></i>
            </a>
        @endif

        {{-- Add more social icons here, e.g. Instagram, LinkedIn --}}
    </div>
</footer>
