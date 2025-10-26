<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full bg-[#D5528E] hover:bg-[#b84477] text-white font-bold py-2 px-4 rounded-lg transition duration-200']) }}>
    {{ $slot }}
</button>