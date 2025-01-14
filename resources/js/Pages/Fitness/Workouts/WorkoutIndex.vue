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
    workouts: Object,
});
const form = useForm({});

const showConfirmDeleteWorkoutModal = ref(false);
const currentWorkoutId = ref(0);

const confirmDeleteWorkout = (id) => {
    showConfirmDeleteWorkoutModal.value = true;
    currentWorkoutId.value = id;
};

const closeModal = () => {
    showConfirmDeleteWorkoutModal.value = false;
};

const deleteWorkout = () => {
    form.delete(route("workouts.destroy", currentWorkoutId.value), {
        onSuccess: () => closeModal(),
    });
};
</script>

<template>

    <Head title="Workout Index" />

    <AuthenticatedLayout>
        <div class="py-2 px-2 mx-auto max-w-7xl">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-700">Workout Index Page</h1>
                </div>
                <div class="relative group">
                    <Link :href="route('workouts.create')"
                        class="flex items-center px-3 py-2 font-semibold text-indigo-400 hover:text-indiogo-600 rounded">
                    <span class="px-3 py-2 font-semibold bg-blue-400 text-white hover:bg-blue-600 flex items-center">
                        <PlusIcon class="h-5 w-5 mr-1" />Create
                    </span>
                    </Link>
                    <!-- Tooltip -->
                    <div
                        class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-2 w-max px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity">
                        Create Workout
                    </div>
                </div>
            </div>
            <div class="mt-6">
                <Table>
                    <template #header>
                        <TableRow>
                            <TableHeaderCell>ID</TableHeaderCell>
                            <TableHeaderCell>Name</TableHeaderCell>
                            <TableHeaderCell class="text-end">Edit</TableHeaderCell>
                            <TableHeaderCell class="text-end">Delete</TableHeaderCell>
                        </TableRow>
                    </template>
                    <template #default>
                        <TableRow v-for="workout in workouts.data" :key="workout.id" class="border-b">
                            <TableDataCell>{{ workout.id }}</TableDataCell>
                            <TableDataCell>{{ workout.name }}</TableDataCell>
                            <TableDataCell>
                                <div class="text-end flex justify-end">
                                    <div class="relative group">
                                        <Link :href="route('workouts.edit', workout.id)"
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
                                        <button @click="confirmDeleteWorkout(workout.id)"
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
                        <Modal :show="showConfirmDeleteWorkoutModal" @close="closeModal">
                            <div class="p-6">
                                <h2 class="text-lg font-semibold text-slate-800 text-center">
                                    Are you sure to delete this Workout ?
                                </h2>
                                <div class="flex mt-6 space-x-4 text-center justify-center">
                                    <DangerButton @click="deleteWorkout()">Delete
                                    </DangerButton>
                                    <SecondaryButton @click="closeModal">Cancel
                                    </SecondaryButton>
                                </div>
                            </div>
                        </Modal>
                    </template>
                </Table>
                <Pagination :meta="workouts.meta" class="mt-4 flex justify-end" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
