<script setup lang="ts">
import { LengthAwarePaginator } from "@/types/pagination";
import { Link } from "@inertiajs/vue3";

const props = defineProps<{
    paginator: LengthAwarePaginator;
}>();
</script>

<template>
    <nav class="join bg-white">
        <template v-for="link in paginator.links">
            <Link
                class="join-item btn btn-outline btn-primary"
                :class="{
                    'btn-active': link.active,
                    'btn-disabled': !link.url,
                }"
                :href="link.url"
                :aria-current="link.active ? 'page' : undefined"
                v-html="link.label"
            >
            </Link>
        </template>
    </nav>
</template>
