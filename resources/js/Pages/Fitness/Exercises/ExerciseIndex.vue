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
import { PencilIcon, TrashIcon, PlusIcon } from '@heroicons/vue/24/solid';
import Pagination from '@/Components/Pagination.vue';

defineProps({
    exercises: Object,
});
const form = useForm({});

const showConfirmDeleteExerciseModal = ref(false);
const currentExerciseId = ref(0);

const confirmDeleteExercise = (id) => {
    showConfirmDeleteExerciseModal.value = true;
    currentExerciseId.value = id;
};

const closeModal = () => {
    showConfirmDeleteExerciseModal.value = false;
};

const deleteExercise = () => {
    form.delete(route("exercises.destroy", currentExerciseId.value), {
        onSuccess: () => closeModal(),
    });
};
</script>

<template>

    <Head title="Exercise Index" />

    <AuthenticatedLayout>
        <div class="py-2 px-2 mx-auto max-w-7xl">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-700">Exercise Index Page</h1>
                </div>
                <div class="relative group">
                    <Link :href="route('exercises.create')"
                        class="flex items-center px-3 py-2 font-semibold text-indigo-400 hover:text-indiogo-600 rounded">
                    <span class="px-3 py-2 font-semibold bg-blue-400 text-white hover:bg-blue-600 flex items-center">
                        <PlusIcon class="h-5 w-5 mr-1" />Create
                    </span>
                    </Link>
                    <!-- Tooltip -->
                    <div
                        class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-2 w-max px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity">
                        Create Exercise
                    </div>
                </div>
            </div>
            <div class="mt-6">
                <Table>
                    <template #header>
                        <TableRow>
                            <TableHeaderCell>ID</TableHeaderCell>
                            <TableHeaderCell>Name</TableHeaderCell>
                            <TableHeaderCell>Kategorie</TableHeaderCell>
                            <TableHeaderCell class="text-end">Edit</TableHeaderCell>
                            <TableHeaderCell class="text-end">Delete</TableHeaderCell>
                        </TableRow>
                    </template>
                    <template #default>
                        <TableRow v-for="exercise in exercises.data" :key="exercise.id" class="border-b">
                            <TableDataCell>{{ exercise.id }}</TableDataCell>
                            <TableDataCell>{{ exercise.name }}</TableDataCell>
                            <TableDataCell>{{ exercise.category.name }}</TableDataCell>
                            <TableDataCell>
                                <div class="text-end flex justify-end">
                                    <div class="relative group">
                                        <Link :href="route('exercises.edit', exercise)"
                                            class="text-green-400 hover:text-green-600">
                                        <PencilIcon class="h-5 w-5" />
                                        </Link>
                                        <!-- Tooltip -->
                                        <div
                                            class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-2 w-max px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity">
                                            Edit
                                        </div>
                                    </div>

                                </div>
                            </TableDataCell>
                            <TableDataCell>
                                <div class="text-end flex justify-end">
                                    <div class="relative group">
                                        <button @click="confirmDeleteExercise(exercise.id)"
                                            class="text-red-400 hover:text-red-600">
                                            <TrashIcon class="h-5 w-5" />
                                        </button>
                                        <!-- Tooltip -->
                                        <div
                                            class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-2 w-max px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity">
                                            Delete
                                        </div>
                                    </div>
                                </div>
                            </TableDataCell>
                        </TableRow>
                        <Modal :show="showConfirmDeleteExerciseModal" @close="closeModal">
                            <div class="p-6">
                                <h2 class="text-lg font-semibold text-slate-800 text-center">
                                    Are you sure to delete this
                                    Exercise ?
                                </h2>
                                <div class="flex mt-6 space-x-4 text-center justify-center">
                                    <DangerButton @click="deleteExercise()">Delete
                                    </DangerButton>
                                    <SecondaryButton @click="closeModal">Cancel
                                    </SecondaryButton>
                                </div>
                            </div>
                        </Modal>
                    </template>
                </Table>
                <Pagination :meta="exercises.meta" class="mt-4 flex justify-end" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
