@php $editing = isset($price) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.date
            name="date"
            label="Date"
            value="{{ old('date', ($editing ? optional($price->date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="price"
            label="Price"
            :value="old('price', ($editing ? $price->price : ''))"
            max="255"
            step="0.01"
            placeholder="Price"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="crop_id" label="Crop" required>
            @php $selected = old('crop_id', ($editing ? $price->crop_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Crop</option>
            @foreach($crops as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
