<script>
</script>

<template>
    <header class="bg-white shadow">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
          <h1 class="text-3xl font-bold tracking-tight text-gray-900">Connecter</h1>
        </div>
    </header>
    <main>
       <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
            <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
              <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                <h2 class="text-rose-800 mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Entrez à votre compte</h2>
              </div>

              <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                <form class="space-y-6" action="#" method="POST">
                  <div>
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Courriel</label>
                    <div class="mt-2">
                      <input id="email" name="email" type="email" autocomplete="email" required="" class="block w-full rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6" />
                    </div>
                  </div>

                  <div>
                    <div class="flex items-center justify-between">
                      <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Mot de passe</label>
                      <div class="text-sm">
                        <a href="#" class="font-semibold text-rose-800 hover:text-red-500">Mot de passe oublié?</a>
                      </div>
                    </div>
                    <div class="mt-2">
                      <input id="password" name="password" type="password" autocomplete="current-password" required="" class="block w-full rounded-md border-0 p-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-rose-800 sm:text-sm sm:leading-6" />
                    </div>
                  </div>

                  <div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-rose-800 px-3 p-3 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-rose-800">Entrez</button>
                  </div>
                </form>

                <p class="mt-10 text-center text-sm text-gray-500">
                  Non inscrit?
                  {{ ' ' }}
                  <a href="#" class="font-semibold leading-6 text-rose-800 hover:text-red-500">Créez votre compte</a>
                </p>
              </div>
            </div>

       </div>
    </main>
</template>