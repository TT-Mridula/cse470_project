<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Login — SkillStacker</title>

  {{-- TEMP: Tailwind CDN for a quick sanity check --}}
  <script src="https://cdn.tailwindcss.com"></script>

  {{-- When your Vite pipeline is working, you can remove the CDN and use Vite: --}}
  {{-- @vite(['resources/css/app.css','resources/js/app.js']) --}}

  <style>html,body{font-family:Inter,system-ui,-apple-system,Segoe UI,Arial,sans-serif}</style>
</head>
<body class="min-h-screen bg-white flex items-center justify-center">
  <div class="w-full max-w-md px-6 py-10">
    <div class="flex justify-center mb-5">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-pink-400" viewBox="0 0 24 24" fill="currentColor">
        <path d="M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20Z"/>
      </svg>
    </div>

    <h1 class="text-3xl font-extrabold text-slate-900 text-center">Welcome back</h1>

    <div class="mt-5">
      <a href="#"
         class="w-full inline-flex items-center justify-center gap-2 rounded-full border border-slate-300 py-2.5 px-4
                text-sm text-slate-800 hover:bg-slate-50 transition">
        <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" class="w-4 h-4" alt="">
        Continue with Google
      </a>
    </div>

    <div class="relative my-5">
      <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-200"></div></div>
      <div class="relative flex justify-center">
        <span class="px-3 bg-white text-slate-500 text-xs">or</span>
      </div>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
      @csrf
      <div>
        <label class="block text-xs font-medium text-slate-700 mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required autofocus
               class="block w-full h-11 rounded-2xl border-slate-300 text-sm px-3
                      focus:border-slate-900 focus:ring-slate-900">
        @error('email') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      <div>
        <div class="flex items-center justify-between mb-1">
          <label class="block text-xs font-medium text-slate-700">Password</label>
          @if (Route::has('password.request'))
          <a class="text-xs text-slate-600 hover:text-slate-900" href="{{ route('password.request') }}">Forgot your password?</a>
          @endif
        </div>
        <input type="password" name="password" required
               class="block w-full h-11 rounded-2xl border-slate-300 text-sm px-3
                      focus:border-slate-900 focus:ring-slate-900">
        @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
      </div>

      <div class="flex items-center gap-2">
        <input id="remember" name="remember" type="checkbox"
               class="rounded border-slate-300 text-slate-900 focus:ring-slate-900">
        <label for="remember" class="text-xs text-slate-700">Remember me</label>
      </div>

      <button type="submit"
              class="w-full rounded-full bg-slate-900 hover:brightness-110 text-white font-semibold
                     py-3 text-sm transition">
        Continue
      </button>

      <p class="text-[11px] text-slate-500 text-center">
        By continuing, you agree to our <a href="#" class="underline">Terms</a> and <a href="#" class="underline">Privacy Policy</a>.
      </p>

      <p class="text-sm text-slate-700 text-center">
        Don’t have an account?
        @if (Route::has('register'))
          <a href="{{ route('register') }}" class="text-slate-900 font-semibold">Sign up</a>
        @endif
      </p>
    </form>
  </div>
</body>
</html>
