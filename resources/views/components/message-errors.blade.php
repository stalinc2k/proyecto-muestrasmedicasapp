      @if (session('error'))
            <div id="alert" class=" text-white bg-red-500 font-bold p-4">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div id="alert" class=" text-white bg-green-500 font-bold p-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('warning'))
            <div id="alert" class=" text-white bg-orange-500 font-bold p-4">
                {{ session('warning') }}
            </div>
        @endif