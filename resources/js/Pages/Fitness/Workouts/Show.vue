<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { BackwardIcon, MinusIcon, PencilIcon, PlusIcon } from "@heroicons/vue/24/solid";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import Table from '@/Components/Table.vue';
import TableDataCell from '@/Components/TableDataCell.vue';
import TableHeaderCell from '@/Components/TableHeaderCell.vue';
import TableRow from '@/Components/TableRow.vue';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { ref } from "vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Modal from "@/Components/Modal.vue";

const props = defineProps({
    workout: {
        type: Object,
        required: true,
    },
    available_exercises: {
        type: Object,
        required: true,
    },
    workout_exercises: {
        type: Object,
        required: true,
    },
    pivot_exercises_workouts: {
        type: Object,
        required: true,
    },
});
const formatter = new Intl.DateTimeFormat('de-DE', { year: 'numeric', month: '2-digit', day: '2-digit' });
const form = useForm({
    name: props.workout?.name,
    datum: props.workout?.datum,
    attach_exercise_id: "",
    detach_exercise_id: "",
    beschreibung: "",
    currentBeschreibung: "",
    errorCurrentBeschreibung: "",
    currentExerciseId: "",
});
const attachExercise = () => {
    form.post(route('workouts.attach.exercise', props.workout.id, parseInt(form.attach_exercise_id)), {
        onSuccess: () => {
            form.beschreibung = "",
            form.attach_exercise_id = "",
            console.log('success attach exercise')
        },
        onError: () => {
            console.log('error attach exercise')
        },
    });
};
const detachExercise = () => {
    form.post(route('workouts.detach.exercise', props.workout.id, parseInt(form.detach_exercise_id)), {
        onSuccess: () => {
            form.detach_exercise_id = "",
            console.log('success detach exercise')
        },
        onError: () => {
            console.log('error detach exercise')
        },
    });
};

// edit Modal
const showEditModal = ref(false);
const currentExerciseId = ref(0);
const currentBeschreibung = ref("");
const errorCurrentBeschreibung = ref("");

const showModalBeschreibung = (id, beschreibung) => {
    form.currentBeschreibung = beschreibung;
    form.errorCurrentBeschreibung = "";
    showEditModal.value = true;
    currentExerciseId.value = id;
};

const closeModal = () => {
    showEditModal.value = false;
    form.errorCurrentBeschreibung = "";
};

const editBeschreibung = (exerciseId) => {
    if (form.currentBeschreibung === "") {
        form.errorCurrentBeschreibung = "Beschreibung is required";
        return;
    }
    closeModal();
    form.currentExerciseId = currentExerciseId.value;
    form.put(route("workouts.update.beschreibung", props.workout,  currentExerciseId.value), {
        onSuccess: () => {
            console.log('success edit beschreibung')
        },
        onError: () => {
            console.log('error edit beschreibung')
        },  
    });
};
</script>

<template>

    <Head title="Create new Workout" />

    <AuthenticatedLayout>
        <div class="mx-auto max-w-7xl">
            <div class="max-w-6xl px-6 py-3 mx-auto rounded-lg shadow-lg bg-slate-100">
                <div class="flex justify-between pb-2 px-5">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-700">Workout</h1>
                    </div>
                    <Link href="#" onclick="history.back()"
                        class="px-3 py-2 font-semibold text-white bg-indigo-500 rounded hover:bg-indigo-700 flex items-center">
                    <BackwardIcon class="h-5 w-5 mr-1" />Back
                    </Link>
                </div>
                <div class="border border-b-1 border-gray-900"></div>
                <div class="my-2 px-5">
                    <div class="flex justify-between">
                        <div>
                            <p class="text-lg font-semibold text-gray-700">Name</p>
                            <p class="text-lg text-gray-500">{{ workout.name }}</p>
                        </div>
                        <div>
                            <p class="text-lg font-semibold text-gray-700">Datum</p>
                            <p class="text-lg text-gray-500">{{ formatter.format(new Date(workout.datum)) }}</p>
                        </div>
                        <div>
                            <p class="text-lg font-semibold text-gray-700">Category</p>
                            <p class="text-lg text-gray-500">{{ workout.category.name }}</p>
                        </div>
                    </div>
                </div>

                <div class="border border-b-1 border-gray-900"></div>

                <div class="mt-3 bg-slate-300 p-5 rounded-m">
                    <Table>
                        <template #header>
                            <TableRow>
                                <TableHeaderCell>Exercise</TableHeaderCell>
                                <TableHeaderCell>Beschreibung</TableHeaderCell>
                                <TableHeaderCell>Edit</TableHeaderCell>
                            </TableRow>
                        </template>
                        <template #default>
                            <TableRow v-for="ew in pivot_exercises_workouts" :key="ew.workout_id" class="border-b">
                                <TableDataCell>{{ ew.exercise.name }}</TableDataCell>
                                <TableDataCell>{{ ew.beschreibung }}</TableDataCell>
                                <TableDataCell>
                                    <div class="flex justify-start">
                                        <div class="relative group">
                                            <button @click="showModalBeschreibung(ew.exercise.id, ew.beschreibung)"
                                                class="text-red-400 hover:text-red-600">
                                                <PencilIcon class="h-5 w-5" />
                                            </button>
                                            <!-- Tooltip -->
                                            <div
                                                class="absolute left-1/2 transform -translate-x-1/2 bottom-full mb-2 w-max px-2 py-1 bg-gray-800 text-white text-sm rounded opacity-0 group-hover:opacity-100 transition-opacity">
                                                Edit
                                            </div>
                                        </div>

                                    </div>
                                </TableDataCell>
                                <Modal :show="showEditModal">
                                    <div class="p-6">
                                        <div class="mt-3">
                                            <InputLabel for="beschreibung" value="Beschreibung" />
                                            <textarea id="beschreibung" rows="4" v-model="form.currentBeschreibung"
                                                class="block w-full mt-1"></textarea>
                                            <InputError class="mt-2" :message="form.errorCurrentBeschreibung" />
                                        </div>
                                        <div class="flex mt-6 space-x-4 text-center justify-center">
                                            <DangerButton @click="editBeschreibung(ew.ex)">Update
                                            </DangerButton>
                                            <SecondaryButton @click="closeModal">Cancel
                                            </SecondaryButton>
                                        </div>
                                    </div>
                                </Modal>
                            </TableRow>
                        </template>
                    </Table>
                </div>

                <div class="flex justify-center bg-gray-200 p-2 rounded-md">
                    <div class="basis-[40vw]">
                        <div>
                            <div class="mt-3">
                                <InputLabel for="attach_exercise_id" value="Attach Exercise" />
                                <select id="attach_exercise_id" v-model="form.attach_exercise_id"
                                    class="block w-full mt-1">
                                    <option value="">Select Exercise</option>
                                    <option v-for="attach_exercise in available_exercises" :key="attach_exercise.id"
                                        :value="attach_exercise.id">
                                        {{ attach_exercise.name }}
                                    </option>
                                </select>
                                <InputError class="mt-2" :message="form.errors.attach_exercise_id" />
                            </div>
                            <div class="mt-3">
                                <InputLabel for="beschreibung" value="Beschreibung" />
                                <textarea id="beschreibung" rows="4" v-model="form.beschreibung"
                                    class="block w-full mt-1"></textarea>
                                <InputError class="mt-2" :message="form.errors.beschreibung" />
                            </div>
                        </div>
                    </div>
                    <div class="basis-[20vw]">
                        <div class="mt-6 flex justify-center items-center">
                        </div>
                        <div class="mt-3 flex justify-center items-center">
                            <Link href="#" @click="attachExercise"
                                class="px-3 py-2 font-semibold text-white bg-indigo-500 rounded hover:bg-indigo-700 flex items-center">
                            <PlusIcon class="h-5 w-5 mr-1" />Attach
                            </Link>
                        </div>
                        <div class="mt-3 flex justify-center mx-4 items-center">
                            <Link href="#" @click="detachExercise"
                                class="px-3 py-2 font-semibold text-white bg-indigo-500 rounded hover:bg-indigo-700 flex items-center">
                            <MinusIcon class="h-5 w-5 mr-1" />Detach
                            </Link>
                        </div>
                    </div>
                    <div class="basis-[40vw]">
                        <div class="mt-3">
                            <InputLabel for="detach_exercise_id" value="Detach Exercises" />
                            <select id="detach_exercise_id" v-model="form.detach_exercise_id" class="block w-full mt-1">
                                <option value="">Select Exercise</option>
                                <option v-for="exercise in workout_exercises" :key="exercise.id" :value="exercise.id">
                                    {{ exercise.name }}
                                </option>
                            </select>
                            <InputError class="mt-2" :message="form.errors.detach_exercise_id" />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>