<script setup>
import Table from '@/Components/Table.vue';
import TableDataCell from '@/Components/TableDataCell.vue';
import TableHeaderCell from '@/Components/TableHeaderCell.vue';
import TableRow from '@/Components/TableRow.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Modal from '@/Components/Modal.vue';
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Head, Link, useForm, router, usePage } from '@inertiajs/vue3';
import { ref, computed, watch } from "vue";
import Pagination from '@/Components/Pagination.vue';
import { PencilIcon, TrashIcon, PlusIcon, XMarkIcon } from '@heroicons/vue/24/solid';
import MagnifyingGlass from '@/Components/Icons/MagnifyingGlass.vue';

defineProps({
    workouts: {
        type: Object,
        required: true,
    },
    categories: {
        type: Object,
        required: true,
    },
});
const page = usePage();
const form = useForm({});

const formatter = new Intl.DateTimeFormat('de-DE', { day: '2-digit', month: '2-digit', year: 'numeric' });

// Searching
let search = ref(usePage().props.search ?? "");
let category_id = ref(usePage().props.category_id ?? "");

// Pagination
let pageNumber = ref(1);

let workoutsUrl = computed(() => {
    let url = new URL(route("workouts.index"));
    url.searchParams.append("page", pageNumber.value);

    if (search.value) {
        url.searchParams.append("search", search.value);
    }

    if (category_id.value) {
        url.searchParams.append("category_id", category_id.value);
    }

    return url;
});
const updatedPageNumber = (link) => {
    pageNumber.value = link.url.split("=")[1];
};
watch(() => workoutsUrl.value, (updatedWorkoutsUrl) => {
    router.visit(updatedWorkoutsUrl, {
            preserveScroll: true,
            preserveState: true,
            replace: true,
        });
    }
);

watch(
    () => search.value,
    (value) => {
        if (value) {
            pageNumber.value = 1;
        }
    }
);

const resetSearch = () => {
    search.value = "";
};

const resetAll = () => {
    search.value = "";
    category_id.value = "";
};

// Delete Workout + Modal Dialog
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
            <div class="flex justify-between items-center border-b border-gray-400 pb-2 mb-2">
                <h1 class="text-2xl font-semibold text-gray-700">Workout Index Page</h1>
            </div>
            <div class="flex justify-between items-center">
                <div class="flex sm:flex-row mt-2">
                    <div class="relative text-sm text-gray-800 col-span-3 flex items-center">
                        <div
                            class="absolute pl-2 left-0 top-0 bottom-0 flex items-center pointer-events-none text-gray-500">
                            <MagnifyingGlass />
                        </div>

                        <input v-model="search" type="text" autocomplete="off" placeholder="Search workout data ..."
                            id="search"
                            class="block rounded-lg border-0 py-2 pl-10 text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                        <button @click="resetSearch"
                            class="text-black-400 hover:text-black-600 ml-1 border border-gray-900 p-1 rounded-md bg-white">
                            <XMarkIcon class="h-5 w-5" />
                        </button>
                    </div>
                    <div class="relative text-sm text-gray-800 col-span-3 flex items-center">
                        <select v-model="category_id"
                            class="block rounded-lg border-0 py-2 ml-5 text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 sm:text-sm sm:leading-6">
                            <option value="">Filter By Category</option>
                            <option v-for="category in categories" :key="category.id" :value="category.id">
                                {{ category.name }}
                            </option>
                        </select>
                        <label class="ml-4 mr-1">Clear All</label>
                        <button @click="resetAll"
                            class="text-black-400 hover:text-black-600 ml-1 p-1 border border-gray-900 rounded-md bg-white">
                            <XMarkIcon class="h-5 w-5" />
                        </button>
                    </div>

                </div>

                <div>
                    <Link :href="route('workouts.create')"
                        class="flex items-center pr-1 font-semibold text-indigo-400 hover:text-indiogo-600 rounded">
                    <span class="px-3 py-2 font-semibold bg-blue-400 text-white hover:bg-blue-600 flex items-center">
                        <PlusIcon class="h-5 w-5" />Create
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
                            <TableHeaderCell>Datum</TableHeaderCell>
                            <TableHeaderCell>Kategorie</TableHeaderCell>
                            <TableHeaderCell class="text-end">Edit</TableHeaderCell>
                            <TableHeaderCell class="text-end">Delete</TableHeaderCell>
                        </TableRow>
                    </template>
                    <template #default>
                        <TableRow v-for="workout in workouts.data" :key="workout.id" class="border-b">
                            <TableDataCell>{{ workout.id }}</TableDataCell>
                            <TableDataCell>{{ workout.name }}</TableDataCell>
                            <TableDataCell>
                                {{ formatter.format(new Date(workout.datum)) }}
                            </TableDataCell>
                            <TableDataCell>{{ workout.category.name }}</TableDataCell>
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
                <Pagination :data="workouts" :updatedPageNumber="updatedPageNumber" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
