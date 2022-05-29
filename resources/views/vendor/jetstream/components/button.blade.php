<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest focus:outline-none disabled:opacity-25 transition ease-in-out duration-150 bg-[#f29200] hover:bg-[#e58a00] focus:bg-[#e58a00] focus:border-[#e58a00] active:bg-[#e58a00] active:border-[#e58a00]']) }}>
    {{ $slot }}
</button>
