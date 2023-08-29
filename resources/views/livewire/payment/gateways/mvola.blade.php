<div>
    <div class="">
        <div wire:loading.flex>
            <div class="w-11/12 p-12 mx-auto mt-10 border rounded shadow md:w-6/12 lg:w-4/12">
                <x-heroicon-o-clock class="w-12 h-12 mx-auto text-gray-400 md:h-24 md:w-24" />
                <p class="text-xl font-medium text-center">{{ __('Wallet Topup') }}</p>
                <p class="text-sm text-center">{{ __('Please wait while we process your payment') }}</p>
            </div>
        </div>

        <div wire:loading.remove
            class="w-11/12 p-4 mx-auto mt-10 border rounded shadow md:w-6/12 lg:w-4/12 md:grid-cols-2">

            {{-- form --}}
            
            <div class="">
                <div class="flex items-center pb-1 my-1 border-b">
                    <div class="">
                        {{ __('Wallet Topup') }}
                    </div>
                    <div class="ml-auto text-right">
                        <p class="text-2xl font-bold">{{ currencyFormat($selectedModel->amount) }}</p>
                      
                    </div>
                </div>
                {{-- instruction --}}
                <p class="mt-1 text-lg font-medium">Mvola Paiement</p>
                <p class="text-md">Montant :{{ currencyFormat($selectedModel->amount) }} </p>

                <p class="pt-2 mt-2 text-lg font-medium border-t">{{ __('Numéro de téléphone') }}</p>
                {{-- form --}}
                
                <x-form  action="initMvolaPayment">
                    <x-input  title="{{ __('Veuillez saisir votre numéro Telma sous format :034xxxxxxx ou 038xxxxxxx') }}" name="phoneNumber"/>
                    <x-buttons.primary  type="submit" title="{{ __('Confirmer') }}" />
                </x-form> 
                
            </div>
      

        </div>

    </div>
</div>
