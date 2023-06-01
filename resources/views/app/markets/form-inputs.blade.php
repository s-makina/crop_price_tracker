@php $editing = isset($market) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $market->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="location"
            label="Location"
            :value="old('location', ($editing ? $market->location : ''))"
            maxlength="255"
            placeholder="Location"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
