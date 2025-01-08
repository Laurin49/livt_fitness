<script setup>
import Table from '@/Components/Table.vue';
import TableDataCell from '@/Components/TableDataCell.vue';
import TableHeaderCell from '@/Components/TableHeaderCell.vue';
import TableRow from '@/Components/TableRow.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps(["categories"]);
const form = useForm({});

const showConfirmDeleteCategoryModal = ref(false);
const currentCategoryId = ref(0);

const confirmDeleteCategory = (id) => {
    showConfirmDeleteCategoryModal.value = true;
    currentCategoryId.value = id;
};

const closeModal = () => {
    showConfirmDeleteCategoryModal.value = false;
};

const deleteCategory = () => {
    form.delete(route("categories.destroy", currentCategoryId.value), {
        onSuccess: () => closeModal(),
    });
};
</script>

<template>

    <Head title="Category Index" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Categories</h2>
        </template>

        <div class="py-2 px-2 mx-auto max-w-7xl">
            <div class="flex justify-between">
                <h1>Categories Index Page</h1>
                <Link :href="route('categories.create')"
                    class="px-3 py-2 font-semibold text-white bg-indigo-500 rounded hover:bg-indigo-700">New Category
                </Link>
            </div>
            <div class="mt-6">
                <Table>
                    <template #header>
                        <TableRow>
                            <TableHeaderCell>ID</TableHeaderCell>
                            <TableHeaderCell>Name</TableHeaderCell>
                            <TableHeaderCell>Action</TableHeaderCell>
                        </TableRow>
                    </template>
                    <template #default>
                        <TableRow v-for="category in categories" :key="category.id" class="border-b">
                            <TableDataCell>{{ category.id }}</TableDataCell>
                            <TableDataCell>{{ category.name }}</TableDataCell>
                            <TableDataCell class="space-x-4">
                                <Link :href="route('categories.edit', category)"
                                    class="text-green-400 hover:text-green-600">Edit
                                </Link>
                                <button @click="confirmDeleteCategory(category.id)"
                                    class="text-red-400 hover:text-red-600">
                                    Delete
                                </button>
                            </TableDataCell>
                        </TableRow>
                        <Modal :show="showConfirmDeleteCategoryModal" @close="closeModal">
                            <div class="p-6">
                                <h2 class="text-lg font-semibold text-slate-800">
                                    Are you sure to delete this
                                    Category?
                                </h2>
                                <div class="flex mt-6 space-x-4">
                                    <DangerButton @click="deleteCategory()">Delete
                                    </DangerButton>
                                    <SecondaryButton @click="closeModal">Cancel
                                    </SecondaryButton>
                                </div>
                            </div>
                        </Modal>
                    </template>
                </Table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
