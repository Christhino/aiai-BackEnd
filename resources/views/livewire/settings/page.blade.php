<div>


    <x-form action="savePageSettings" :noClass="true">
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

            <x-textarea title="{{ __('Driver Verification Document Instructions') }}" name="driverDocumentInstructions" />
            <x-input title="{{ __('Max Driver Selectable Documents') }}" name="driverDocumentCount" type="number" />
            <x-textarea title="{{ __('Vendor Verification Document Instructions') }}" name="vendorDocumentInstructions" />
            <x-input title="{{ __('Max Vendor Selectable Documents') }}" name="vendorDocumentCount" type="number" />
        </div>
        <x-buttons.primary title="{{ __('Save Changes') }}" />


    </x-form>


</div>
