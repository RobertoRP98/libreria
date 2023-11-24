<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import WarningButton from '@/Components/WarningButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import Modal from '@/Components/Modal.vue';
import {Head, useForm} from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';
import Swal from 'sweetalert2';
import vueTailwindPagination from '@ocrv/vue-tailwind-pagination';


const nameInput = ref(null);
const modal = ref(false);
const title = ref('');
const operation = ref(1);
const id=ref('');


const props = defineProps({
    books: Object,
    authors: Object,
    categories:Object,
});

const form = useForm({name:'',author_id:'',category_id:''});

const formPage = useForm({});
const onPageClick = (event)=>{
    formPage.get(route('books.index',{page:event}));
}

const openModal = (op,name,author,category,book)=>{
    modal.value= true;
    nextTick(()=>nameInput.value.focus());
    operation.value=op;
    id.value=book;
    if(op==1){
        title.value="Create Book"
    }
    else{
        title.value="Edit Book";
        form.name=name;
        form.author_id=author;
        form.category_id=category;
    }
}

const closeModal = () => {
    modal.value=false;
    form.reset();
}

const save = () => {
    if(operation.value==1){
        form.post(route('books.store'),{
            onSuccess:() => {ok('Book created')}
        });
    }
    else{
     form.put(route('books.update',id.value),{
        onSuccess:() => {ok('Book update')}
     });   
    }
}

const ok = (msj) => {
    form.reset();
    closeModal();
    Swal.fire({title:msj,icon:'success'});
}

const deleteBook = (id,name) =>{
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
            form.delete(route('books.destroy',id),{
                onSuccess:() => {ok('Book deleted')}
            });
        }
    });
}


</script>

<template>
    <AppLayout title="Books">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Books
            </h2>
        </template>

        <div class="py-12">
            <div class="bg-white grid w-screen place-items-center">
                <div class="mt-3 mb-3 flex">
                    <PrimaryButton @click="$event=>openModal(1)">
                        <i class="fa-solid fa-plus-cirle"></i>Add 
                    </PrimaryButton>
                 </div>
            </div>

            <div class=" bg-white grid w-screen place-items-center overflow-x-auto">
                <table class="table-auto border border-gray-400">
                    <thead class="border">
                        <tr class="bg-gray-500 text-white">
                            <th class="px-4 py-4">Nombre</th>
                            <th class="px-4 py-4">Autor</th>
                            <th class="px-4 py-4">Categoria</th>
                            <th class="px-4 py-4">Editar</th>
                            <th class="px-4 py-4">Borrar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="boo, i in books.data" :key="boo.id">
                        <td class="border border-gray-400 px-4 py-4">{{ (boo.name) }}</td>
                        <td class="border border-gray-400 px-4 py-4">{{ (boo.author.name) }}</td>
                        <td class="border border-gray-400 px-4 py-4">{{ (boo.category.name) }}</td>

                        <td class="border border-gray-400 px-4 py-4"> 
                            <WarningButton @click="event=>openModal(2,boo.name,boo.author_id,boo.category_id)">
                             <i class="fa-solid fa-edit"></i>   
                            </WarningButton>
                        </td>

                        <td class="border border-gray-400 px-4 py-4"> 
                        <DangerButton @click="deleteBook(boo.id,boo.name)">
                        <i class="fa-solid fa-trash"></i>
                       </DangerButton> </td>

 
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="bg-white grid w-screen place-items-center">
                <vueTailwindPagination 
                :current="books.currentPage" :total="books.total"
                :per-page="books.perPage"
                @page-changed="$event=>onPageClick($event)">
                </vueTailwindPagination>
            </div>
        </div>

        <modal :show="modal" @close="closeModal">
            <h2 class="p-3 text-lg font.medium text-hray-900">{{ title }}</h2>
            <div class="p-3 mt-6">
                <InputLabel for="name" value="Name"></InputLabel>
                <TextInput id="name" ref="nameInput"
                v-model="form.name" type="text" class="mt-1 block w-3/4"
                placeholder="Name">
                </TextInput>
                <InputError :message="form.errors.name" class="mt-2"></InputError>
            </div>

            <div class="p-3 mt-6">
                <InputLabel for="author_id" value="Author"></InputLabel>
                <SelectInput id="author_id" :options="authors"
                v-model="form.author_id" class="mt-1 block w-3/4">
                </SelectInput>
                <InputError :message="form.errors.author_id" class="mt-2"></InputError>
            </div>


            <div class="p-3 mt-6">
                <InputLabel for="category_id" value="Category"></InputLabel>
                <SelectInput id="category_id" :options="categories"
                v-model="form.category_id" class="mt-1 block w-3/4">
                </SelectInput>
                <InputError :message="form.errors.category_id" class="mt-2"></InputError>
            </div>


            <div class="p-3 mt-6">
                <PrimaryButton :disable="form.processing" @click="save">
                    <i class="fa-solid fa-save"></i>Save
                </PrimaryButton>
            </div>

            <div class="p-3 mt-6 flex justify-end">
                <SecondaryButton class="ml-3" :disable="form.processing"
                @click="closeModal"> 
                Cancel
                </SecondaryButton>
            </div>


        </modal>

        
    </AppLayout>
</template>