<template>
    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" class="relative z-50" @close="handleClose">
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black bg-opacity-25" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center">
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all">
                            <DialogTitle
                                as="h3"
                                class="text-lg font-medium leading-6 text-gray-900 border-b pb-2"
                            >
                                Resumen de Cotización
                            </DialogTitle>

                            <div class="mt-4 space-y-4">
                                <div>
                                    <h4 class="font-bold text-gray-700">Información del Cliente:</h4>
                                    <p class="mt-1">{{ clienteName }}</p>
                                </div>

                                <div>
                                    <h4 class="font-bold text-gray-700">Productos Seleccionados:</h4>
                                    <div class="mt-2 space-y-2">
                                        <div
                                            v-for="item in cart"
                                            :key="item.id"
                                            class="p-2 bg-gray-50 rounded"
                                        >
                                            <p class="font-medium">{{ item.nombre }}</p>
                                            <div class="text-sm text-gray-600">
                                                <p>Cantidad: {{ item.cantidad }}</p>
                                                <p>Precio unitario: ${{ item.precio }}</p>
                                                <p class="font-medium">Subtotal: ${{ item.cantidad * item.precio }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="border-t pt-4">
                                    <h4 class="font-bold text-gray-700">Total Final:</h4>
                                    <p class="text-2xl font-bold text-green-600">${{ total }}</p>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end space-x-3">
                                <button
                                    type="button"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                    @click="handleClose"
                                >
                                    Cerrar
                                </button>
                                <button
                                    type="button"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-green-100 px-4 py-2 text-sm font-medium text-green-900 hover:bg-green-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-green-500 focus-visible:ring-offset-2"
                                    @click="handleSave"
                                >
                                    Guardar Cotización
                                </button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle
} from '@headlessui/vue';

const props = defineProps({
    isOpen: {
        type: Boolean,
        required: true
    },
    clienteName: {
        type: String,
        required: true
    },
    cart: {
        type: Array,
        required: true
    },
    total: {
        type: Number,
        required: true
    }
});

const emit = defineEmits(['close', 'save']);

const handleClose = () => {
    emit('close');
};

const handleSave = () => {
    emit('save');
    handleClose();
};
</script>
