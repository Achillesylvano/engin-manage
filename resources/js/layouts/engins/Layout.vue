<script setup lang="ts">

</script>

<template>
    <div class="px-4 py-6">
        <div class="flex flex-col space-y-8 md:space-y-0 lg:flex-row lg:space-y-0 lg:space-x-12">
            <!-- <Separator class="my-6 md:hidden" /> -->
            <div class="flex-1 w-full">
                <section class="w-full space-y-12">
                    <slot />
                </section>
            </div>
        </div>
    </div>
</template>
