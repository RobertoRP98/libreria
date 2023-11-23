<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const props = defineProps({
    authors: Object});

const form = useForm({id:''});

const deleteAuthor = (id,name) =>{
    const alerta = Swal.mixin({
        buttonsStyling:true
    });
    alerta.fire({
        title:'Estas seguro de eliminar'+name+'?',
        icon:'question', showCancelButton:true,
        confirmButtonText:'<i class="fa-solid fa-check"> </i> Si, eliminar',
        cancelButtonText: '<i class="fa-solid fa-ban"> </i> Cancelar'
    }).then((result)=>{

        if(result.isConfirmed){
            console.log(id);
            form.delete(route('authors.destroy',id));
        }
    });
}


</script>

<template>
    <AppLayout title="Authors">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Authors
            </h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid w-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                    <Link :href="route('authors.create')"
                    :class="'px-4 py-2 bg-gray-800 text-white border rounded-md font-semibold text-xs'"> 
                    <i class="fa-solid fa-plus-circle"></i> Add </Link>
                 </div>
            </div>

            <div class=" bg-white grid w-screen place-items-center">
                <table class="table-auto border border-gray-400">
                    <thead class="border">
                        <tr class="bg-gray-500 text-white">
                            <th class="px-4 py-4">ID</th>
                            <th class="px-4 py-4">Nombre</th>
                            <th class="px-4 py-4">Apellido Paterno</th>
                            <th class="px-4 py-4">Apellido Materno</th>
                            <th class="px-4 py-4">Editar</th>
                            <th class="px-4 py-4">Borrar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="auth, i in authors" :key="auth.id">
                        <td class="border border-gray-400 px-4 py-4">{{ (auth.id) }}</td>
                        <td class="border border-gray-400 px-4 py-4">{{ (auth.name) }}</td>
                        <td class="border border-gray-400 px-4 py-4">{{ (auth.last_name) }}</td>
                        <td class="border border-gray-400 px-4 py-4">{{ (auth.middle_name) }}</td>

                        <td class="border border-gray-400 px-4 py-4"> <Link :href="route('authors.edit',auth.id)"
                        :class="'px-4 py-2 bg-yellow-400 text-white border rounded-md font-semibold text-xs'"> 
                        <i class="fa-solid fa-edit"></i> </Link> </td>

                        <td class="border border-gray-400 px-4 py-4"> 
                        <DangerButton @click="deleteAuthor(auth.id,auth.name)">
                        <i class="fa-solid fa-trash"></i>
                       </DangerButton> </td>

 
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </AppLayout>
</template>