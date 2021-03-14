<template>
    <div class="flex flex-row mt-2">
        <template v-for="i in 24" :key="i">
            <span class="inline-flex items-center justify-center px-3 py-2 text-xs font-bold leading-none border border-gray-600">{{ String(i - 1).padStart(2, '0') }}</span>
        </template>
    </div>
    <div class="flex flex-row mb-2">
        <template v-for="i in 24" :key="i">
            <span class="inline-flex items-center justify-center px-3 py-2 text-xs font-bold leading-none border border-gray-600 text-white bg-gray-800">{{ String(i - 1).padStart(2, '0') }}</span>
        </template>
    </div>
</template>