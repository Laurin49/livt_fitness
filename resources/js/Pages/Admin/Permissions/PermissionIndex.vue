<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { defineProps } from "vue";

defineProps(["permissions"]);
const form = useForm({});

</script>

<template>

    <Head title="Users" />

    <AdminLayout>
        <div class="py-4 mx-auto max-w-7xl">
            <div class="flex justify-between">
                <h1>Permissions Index Page</h1>
            </div>
        </div>
    </AdminLayout>
</template>