<x-guest-layout>
 <x-jet-authentication-card>
   <x-slot name="logo">
       <x-jet-authentication-card-logo />
   </x-slot class="max-auto">
 <x-jet-validation-errors class="mb-3"/>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif
        <!-- Login-->
             <div class=row>
                <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2">
                    <h2 class="card-title fw-bold mb-3 text-dark"><b>Iniciar Sesión</b></h2>
                    <form class="auth-login-form " action="{{ route('login') }}" method="POST">
                    @csrf
              </div>
            </div>
             <div class="mb-1">
                    <label class="form-label text-dark mb-1" for="email" ><b>Usuario</b></label>
                    <input class="form-control border border-primary " id="email" type="text" required name="email" aria-describedby="email" autofocus="" tabindex="1"/>
             </div>
             <div class="mt-3">
                  <div class="d-flex justify-content-between mb-1">
                       <label class="form-label text-dark" for="password"><b>Contraseña</b></label><i data-feather='eye'></i>
                       <div class="d-flex justify-content-between"><a 
                         href="{{ route('password.request') }}"><small class="text-green-600">Olvide mi contraseña</small></a>
                 </div>
             </div>       
             <div class="input-group input-group-merge form-password-toggle">
                   <input class="form-control form-control-merge border-primary" required id="password" type="password"
                   name="password" aria-describedby="password"
                   tabindex="2" />
             </div>
             <div class="mb-1">
                 <div class="form-check">
                     <input class="form-check-input border-primary" id="remember-me" type="checkbox" tabindex="3" />
                     <label class="form-check-label text-dark" for="remember-me">Recordar datos</label>
                 </div>
            </div>
                 <button class="btn btn-primary w-100 mt-2" type="submit" tabindex="4">INGRESAR</button>
             </form>
                <p class="text-center mt-2"><span>¿Aun no Tienes Cuenta?</span><a
                  href="{{ route('register') }}"><span class="text-green-600">&nbsp;<b>Regístrate</b></span></a>
               </p>  
                </div>
            </div>

        </div>
        <!-- /Login -->

 </x-jet-authentication-card>

</x-guest-layout>


