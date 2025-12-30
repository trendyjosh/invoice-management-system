<template>
    <div class="overflow-x-auto">
        <table class="table bg-white dark:bg-gray-800">
            <thead>
                <slot name="head"></slot>
            </thead>
            <tbody>
                <slot name="body"></slot>
            </tbody>
        </table>
    </div>
</template>
