<script setup>
import { useForm } from '@inertiajs/vue3';
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const props = defineProps({
  priceMatrix: Object,
});

const form = useForm({
  base_fee: props.priceMatrix.base_fee,
  volume_rate: props.priceMatrix.volume_rate,
  weight_rate: props.priceMatrix.weight_rate,
  package_rate: props.priceMatrix.package_rate,
});

const updateMatrix = () => form.put(route('admin.price-matrix.update'));
</script>

<template>
  <EmployeeLayout title="Price Matrix">
    <h1 class="text-xl font-bold mb-4">Update Price Matrix</h1>

    <form @submit.prevent="updateMatrix" class="space-y-4">
      <div>
        <InputLabel for="base_fee" value="Base Fee" />
        <TextInput id="base_fee" v-model="form.base_fee" type="number" required />
      </div>

      <div>
        <InputLabel for="volume_rate" value="Volume Rate" />
        <TextInput id="volume_rate" v-model="form.volume_rate" type="number" required />
      </div>

      <div>
        <InputLabel for="weight_rate" value="Weight Rate" />
        <TextInput id="weight_rate" v-model="form.weight_rate" type="number" required />
      </div>

      <div>
        <InputLabel for="package_rate" value="Package Rate" />
        <TextInput id="package_rate" v-model="form.package_rate" type="number" required />
      </div>

      <PrimaryButton :disabled="form.processing">Update</PrimaryButton>
    </form>
  </EmployeeLayout>
</template>
