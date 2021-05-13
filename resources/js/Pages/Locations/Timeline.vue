<template>
    <div>
        <div class="flex flex-row mt-2">
            <template v-for="i in 24" :key="i">
                <div class="flex-auto text-center border border-gray-600 px-3 py-3 text-xs font-bold leading-none">
                    {{ String(i - 1).padStart(2, '0') }}
                </div>
            </template>
        </div>
        <div class="flex flex-row mb-2">
            <template v-for="i in 24" :key="i">
                <div class="flex-auto text-center py-3 px-2 border border-gray-600 text-xs font-bold leading-none text-white">
                    <div class="flex flex-row">
                        <div class="flex-auto bg-gray-800 w-px">1</div>
                        <div class="flex-auto bg-gray-800 w-px"></div>
                        <div class="flex-auto bg-gray-800 w-px"></div>
                        <div class="flex-auto bg-gray-800 w-px"></div>
                        <div class="flex-auto bg-gray-800"></div>
                        <div class="flex-auto bg-gray-800"></div>
                        <div class="flex-auto bg-gray-800"></div>
                        <div class="flex-auto bg-gray-800"></div>
                        <div class="flex-auto bg-gray-800"></div>
                        <div class="flex-auto bg-gray-100"></div>
                        <div class="flex-auto bg-gray-100"></div>
                        <div class="flex-auto bg-gray-100"></div>
                        <div class="flex-auto bg-gray-100"></div>
                        <div class="flex-auto bg-gray-100"></div>
                        <div class="flex-auto bg-gray-100"></div>
                        <div class="flex-auto bg-gray-100"></div>
                        <div class="flex-auto bg-gray-100"></div>
                        <div class="flex-auto bg-gray-800"></div>
                        <div class="flex-auto bg-gray-800"></div>
                        <div class="flex-auto bg-gray-800"></div>
                        <div class="flex-auto bg-gray-800"></div>
                        <div class="flex-auto bg-gray-800"></div>
                        <div class="flex-auto bg-gray-800"></div>
                        <div class="flex-auto bg-gray-800"></div>
                        <div class="flex-auto bg-gray-800"></div>
                        <div class="flex-auto bg-gray-800"></div>
                        <div class="flex-auto bg-gray-800"></div>
                        
                    </div>
                </div>
            </template>
        </div>
        <!-- <div class="flex flex-row mt-2">
            <template v-for="i in 24" :key="i">
                <span class="inline-flex items-center justify-center px-3 py-2 text-xs font-bold leading-none border border-gray-600">{{ String(i - 1).padStart(2, '0') }}</span>
            </template>
        </div> -->
        <!-- <div class="flex flex-row mb-2">
            <template v-for="i in 24" :key="i">
                <span class="inline-flex items-center justify-center px-3 py-2 text-xs font-bold leading-none border border-gray-600 text-white bg-gray-800">{{ String(i - 1).padStart(2, '0') }}</span>
            </template>
        </div> -->
    </div>
</template>