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
import { PlusIcon, PencilIcon, TrashIcon } from '@heroicons/vue/24/solid'

defineProps(["exercises"]);
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
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Exercises</h2>
        </template>

        <div class="py-2 px-2 mx-auto max-w-7xl">
            <div class="flex justify-between">
                <h1>Exercise Index Page</h1>
                <Link :href="route('exercises.create')"
                    class="px-3 py-2 font-semibold text-white bg-indigo-500 rounded hover:bg-indigo-700">
                <span class="flex items-center">
                    <PlusIcon class="h-5 w-5 mr-1" />Exercise
                </span>
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
                        <TableRow v-for="exercise in exercises" :key="exercise.id" class="border-b">
                            <TableDataCell>{{ exercise.id }}</TableDataCell>
                            <TableDataCell>{{ exercise.name }}</TableDataCell>
                            <TableDataCell class="space-x-4 flex items-center">
                                <Link :href="route('exercises.edit', exercise)"
                                    class="text-blue-400 hover:text-blue-600">
                                <PencilIcon class="h-5 w-5 mr-1" />
                                </Link>
                                <button @click="confirmDeleteExercise(exercise.id)" 
                                    class="text-red-400 hover:text-red-600">
                                    <TrashIcon class="h-5 w-5 mr-1"/>
                                </button>
                            </TableDataCell>
                        </TableRow>
                        <Modal :show="showConfirmDeleteExerciseModal" @close="closeModal">
                            <div class="p-6">
                                <h2 class="text-lg font-semibold text-slate-800">
                                    Are you sure to delete this
                                    Exercise ?
                                </h2>
                                <div class="flex mt-6 space-x-4">
                                    <DangerButton @click="deleteExercise()">Delete
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
