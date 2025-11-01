<script setup lang="ts">
import { router } from '@inertiajs/vue3'
import { Button } from '@/components/ui/button'

interface PaginationLink {
    url: string | null
    label: string
    active: boolean
}

interface Props {
    links: PaginationLink[]
    lastPage: number
}

const props = defineProps<Props>()

function navigate(url: string | null) {
    if (url) {
        router.visit(url)
    }
}
</script>

<template>
    <div v-if="lastPage > 1" class="flex justify-center gap-2">
        <Button
            v-for="(link, index) in links"
            :key="index"
            :variant="link.active ? 'default' : 'outline'"
            size="sm"
            @click="navigate(link.url)"
            :disabled="!link.url"
        >
            <span v-html="link.label" />
        </Button>
    </div>
</template>
