<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form=useForm({
    name:'',
    last_name:'',
    middle_name:'',

});

</script>

<template>
    <AppLayout title="Create Author">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Author
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form @submit.prevent="$event => form.post(route('authors.store'))"
                class="mt-6 space-y-6 max-w-xl">
                <!-- Inician los Inputs-->
                <InputLabel for="name" value="Author"></InputLabel>
                <TextInput id="name" v-model="form.name" autofocus required 
                type="text" placeholder="Nombre"
                class="mt-1 block w-full"></TextInput>
                

                <TextInput id="last_name" v-model="form.last_name" autofocus required 
                type="text" placeholder="Primer apellido"
                class="mt-1 block w-full"></TextInput>

                <TextInput id="middle_name" v-model="form.middle_name" autofocus required 
                type="text" placeholder="Segundo apellido"
                class="mt-1 block w-full"></TextInput>


                <!--Terminan los Inputs-->
                <InputError :message="form.errors.name" class="mt-2"></InputError>

                <PrimaryButton :disabled="form.processing">
                    <i class="fa-solid fa-save"></i> Save
                </PrimaryButton>
                </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>