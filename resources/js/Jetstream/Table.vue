<template>
    <table class="table-auto w-full overflow-x-auto">
        <thead class="border-b-2 border-yellow-400">
            <slot name="header"></slot>
        </thead>
        <tbody>
            <slot name="body"></slot>
        </tbody>
    </table>
</template>
