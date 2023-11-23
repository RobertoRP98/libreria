<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import {Head, Link, useForm} from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const props = defineProps({
    categories: Object});

const form = useForm({id:''});

const deleteCategory = (id,name) =>{
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
            form.delete(route('categories.destroy',id));
        }
    });
}


</script>

<template>
    <AppLayout title="Authors">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Categories
            </h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid w-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                    <Link :href="route('categories.create')"
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
                            <th class="px-4 py-4">Editar</th>
                            <th class="px-4 py-4">Borrar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cat, i in categories" :key="cat.id">
                        <td class="border border-gray-400 px-4 py-4">{{ (cat.id) }}</td>
                        <td class="border border-gray-400 px-4 py-4">{{ (cat.name) }}</td>

                        <td class="border border-gray-400 px-4 py-4"> <Link :href="route('categories.edit',cat.id)"
                        :class="'px-4 py-2 bg-yellow-400 text-white border rounded-md font-semibold text-xs'"> 
                        <i class="fa-solid fa-edit"></i> </Link> </td>

                        <td class="border border-gray-400 px-4 py-4"> 
                        <DangerButton @click="deleteCategory(cat.id,cat.name)">
                        <i class="fa-solid fa-trash"></i>
                       </DangerButton> </td>

 
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </AppLayout>
</template>