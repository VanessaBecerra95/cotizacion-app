<template>
    <div class="container mx-auto p-4">
      <h1 class="text-2xl font-bold mb-4">Crear Usuario</h1>

      <form @submit.prevent="createUser" class="max-w-md mx-auto">
        <div class="mb-4">
          <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
          <input
            id="nombre"
            v-model="form.nombre"
            type="text"
            required
            class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          />
        </div>

        <div class="mb-4">
          <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            required
            class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
          />
        </div>

        <div class="flex justify-end">
          <button
            type="submit"
            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            :disabled="form.processing"
          >
            {{ form.processing ? 'Creando...' : 'Crear Usuario' }}
          </button>
        </div>
      </form>

      <div v-if="showSuccessMessage" class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
        Usuario creado exitosamente.
      </div>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';
  import { useForm } from '@inertiajs/vue3';

  const form = useForm({
    nombre: '',
    email: '',
  });

  const showSuccessMessage = ref(false);

  const createUser = () => {
    form.post(route('clientes.store'), {
      preserveScroll: true,
      onSuccess: () => {
        form.reset();
        showSuccessMessage.value = true;
        setTimeout(() => {
          showSuccessMessage.value = false;
        }, 3000);
      },
    });
  };
  </script>
