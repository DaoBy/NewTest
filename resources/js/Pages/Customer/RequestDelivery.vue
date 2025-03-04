<script setup>
import { ref, computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';

// Form Step Management
const currentStep = ref(1);




// Form Data
const form = useForm({
  customerType: 'individual', // Default: Individual
  senderFirstName: '',
  senderLastName: '',
  senderCompanyName: '',
  senderMobile: '',
  senderStreet: '',
  senderCity: '',
  senderProvince: '',
  senderZip: '',
  dropOffBranch: '',
  receiverFirstName: '',
  receiverLastName: '',
  receiverMobile: '',
  receiverStreet: '',
  receiverCity: '',
  receiverProvince: '',
  receiverZip: '',
  pickUpBranch: '',
  itemDescription: '',
  itemHeight: '',
  itemWidth: '',
  itemLength: '',
  itemWeight: '',
  itemQuantity: '',
});

// Available branches
const branches = ['Naga', 'Malabon', 'Legazpi'];

// Calculate Total Volume (Height × Width × Length)
const totalVolume = computed(() => {
  const { itemHeight, itemWidth, itemLength } = form;
  if (!itemHeight || !itemWidth || !itemLength) return 0; // Handle partial inputs
  return itemHeight * itemWidth * itemLength;
});

// Validate Current Step
const validateStep = () => {
  form.clearErrors();

  if (currentStep.value === 1) {
    if (form.customerType === 'individual') {
      if (!form.senderFirstName) form.setError('senderFirstName', 'First Name is required.');
      if (!form.senderLastName) form.setError('senderLastName', 'Last Name is required.');
    } else {
      if (!form.senderCompanyName) form.setError('senderCompanyName', 'Company Name is required.');
      if (!form.senderFirstName) form.setError('senderFirstName', 'First Name is required.');
      if (!form.senderLastName) form.setError('senderLastName', 'Last Name is required.');
    }
    if (!form.senderMobile) form.setError('senderMobile', 'Mobile number is required.');
    if (!form.senderStreet) form.setError('senderStreet', 'Street is required.');
    if (!form.senderCity) form.setError('senderCity', 'City is required.');
    if (!form.senderProvince) form.setError('senderProvince', 'Province is required.');
    if (!form.senderZip) form.setError('senderZip', 'ZIP Code is required.');
    if (!form.dropOffBranch) form.setError('dropOffBranch', 'Drop-off branch is required.');
  }

  if (currentStep.value === 2) {
    if (!form.receiverFirstName) form.setError('receiverFirstName', 'First Name is required.');
    if (!form.receiverLastName) form.setError('receiverLastName', 'Last Name is required.');
    if (!form.receiverMobile) form.setError('receiverMobile', 'Mobile number is required.');
    if (!form.receiverStreet) form.setError('receiverStreet', 'Street is required.');
    if (!form.receiverCity) form.setError('receiverCity', 'City is required.');
    if (!form.receiverProvince) form.setError('receiverProvince', 'Province is required.');
    if (!form.receiverZip) form.setError('receiverZip', 'ZIP Code is required.');
    if (!form.pickUpBranch) form.setError('pickUpBranch', 'Pick-up branch is required.');
  }

  if (currentStep.value === 3) {
    if (!form.itemDescription) form.setError('itemDescription', 'Package description is required.');
    if (!form.itemHeight) form.setError('itemHeight', 'Height is required.');
    if (!form.itemWidth) form.setError('itemWidth', 'Width is required.');
    if (!form.itemLength) form.setError('itemLength', 'Length is required.');
    if (!form.itemWeight) form.setError('itemWeight', 'Weight is required.');
    if (!form.itemQuantity) form.setError('itemQuantity', 'Quantity is required.');

    // Enforce package limits
    if (totalVolume.value > 10) form.setError('itemHeight', 'Package volume exceeds 10 m³.');
    if (form.itemWeight > 100) form.setError('itemWeight', 'Package weight exceeds 100 kg.');
  }

  return !Object.keys(form.errors).length;
};

// Proceed to Next Step
const nextStep = () => {
  if (validateStep()) currentStep.value++;
};

// Go Back to Previous Step
const prevStep = () => {
  if (currentStep.value > 1) currentStep.value--;
};

// Submit Form
const submitRequest = () => {
  if (validateStep()) {
    form.post('/request-delivery', {
      onSuccess: () => {
        alert('Delivery request submitted successfully!');
        form.reset(); // Reset the form after submission
      },
      onError: (errors) => {
        console.error('Submission failed:', errors);
      },
    });
  }
};
</script>

<template>
  <GuestLayout>
    <div class="container mx-auto px-6 py-12 flex gap-12">
      <!-- Progress Indicator (Left Side) -->
      <div class="w-1/4 space-y-8">
        <h2 class="text-2xl font-bold">Progress</h2>
        <div class="flex flex-col gap-4">
          <div v-for="(step, index) in ['Sender Info', 'Receiver Info', 'Item Details']" :key="index" class="flex items-center gap-4">
            <div :class="[
                'w-10 h-10 rounded-full flex items-center justify-center',
                currentStep === index + 1 ? 'bg-black text-white' : 'bg-gray-300 text-gray-600'
              ]">
              {{ index + 1 }}
            </div>
            <span :class="currentStep === index + 1 ? 'font-semibold' : 'text-gray-500'">
              {{ step }}
            </span>
          </div>
        </div>
      </div>

      <!-- Form Content (Right Side) -->
      <div class="w-3/4 space-y-8">
        <h1 class="text-3xl font-bold">Request a Delivery</h1>

       <!-- Step 1: Sender Details -->
<div v-if="currentStep === 1" class="space-y-6">
  <h2 class="text-xl flex items-center justify-center font-semibold">Sender Details</h2>

  <!-- Customer Type (Radio Buttons) -->
  <div>
    <InputLabel value="Customer Type" class="mb-2" />
    <div class="flex gap-6">
      <label class="flex items-center">
        <input type="radio" value="individual" v-model="form.customerType" class="mr-2" />
        Individual
      </label>
      <label class="flex items-center">
        <input type="radio" value="company" v-model="form.customerType" class="mr-2" />
        Company
      </label>
    </div>
  </div>

  
  <!-- Company Fields (if Company is selected) -->
  <div v-if="form.customerType === 'company'" class="space-y-2">
    <InputLabel for="senderCompanyName" value="Company Name" />
    <TextInput id="senderCompanyName" v-model="form.senderCompanyName" class="w-full" />
    <InputError :message="form.errors.senderCompanyName" />
  </div>

  <!-- Shared Fields (For Both Individual and Company) -->
  <div class="space-y-4">
    <div>
      <InputLabel for="senderFirstName" value="First Name" />
      <TextInput id="senderFirstName" v-model="form.senderFirstName" class="w-full" />
      <InputError :message="form.errors.senderFirstName" />
    </div>

    <div>
      <InputLabel for="senderLastName" value="Last Name" />
      <TextInput id="senderLastName" v-model="form.senderLastName" class="w-full" />
      <InputError :message="form.errors.senderLastName" />
    </div>

    <div>
      <InputLabel for="senderMobile" value="Mobile Number" />
      <TextInput id="senderMobile" v-model="form.senderMobile" class="w-full" />
      <InputError :message="form.errors.senderMobile" />
    </div>
  </div>

  <!-- Address Fields -->
  <div class="space-y-4">
    <InputLabel :value="form.customerType === 'company' ? 'Company Address' : 'Full Address'" />

    <TextInput id="senderStreet" v-model="form.senderStreet" placeholder="Street" class="w-full" />
    <InputError :message="form.errors.senderStreet" />

    <div class="grid grid-cols-2 gap-4">
      <div>
        <TextInput id="senderCity" v-model="form.senderCity" placeholder="City" class="w-full" />
        <InputError :message="form.errors.senderCity" />
      </div>

      <div>
        <TextInput id="senderProvince" v-model="form.senderProvince" placeholder="Province" class="w-full" />
        <InputError :message="form.errors.senderProvince" />
      </div>
    </div>

    <TextInput id="senderZip" v-model="form.senderZip" placeholder="ZIP Code" class="w-full" />
    <InputError :message="form.errors.senderZip" />
  </div>

  <!-- Drop-off Branch -->
  <div class="space-y-2">
    <InputLabel for="dropOffBranch" value="Drop-off Branch" />
    <v-select
      v-model="form.dropOffBranch"
      :items="branches"
      variant="outlined"
      density="comfortable"
      class="w-full"
    ></v-select>
    <InputError :message="form.errors.dropOffBranch" />
  </div>



          <!-- Navigation Buttons -->
          <div class="flex justify-center mt-6">
            <PrimaryButton @click="nextStep">Next</PrimaryButton>
          </div>
        </div>

        <!-- Step 2: Receiver Details -->
<div v-if="currentStep === 2" class="space-y-6">
  <h2 class="text-xl flex items-center justify-center font-semibold">Receiver Details</h2>

  <!-- Receiver First Name -->
  <div>
    <InputLabel for="receiverFirstName" value="First Name" />
    <TextInput id="receiverFirstName" v-model="form.receiverFirstName" class="w-full" />
    <InputError :message="form.errors.receiverFirstName" />
  </div>

  <!-- Receiver Last Name -->
  <div>
    <InputLabel for="receiverLastName" value="Last Name" />
    <TextInput id="receiverLastName" v-model="form.receiverLastName" class="w-full" />
    <InputError :message="form.errors.receiverLastName" />
  </div>

  <!-- Receiver Mobile -->
  <div>
    <InputLabel for="receiverMobile" value="Mobile Number" />
    <TextInput id="receiverMobile" v-model="form.receiverMobile" class="w-full" />
    <InputError :message="form.errors.receiverMobile" />
  </div>

  <!-- Receiver Address -->
  <div class="space-y-4">
    <h3 class="text-lg font-medium">Receiver Address</h3>

    <div>
      <InputLabel for="receiverStreet" value="Street" />
      <TextInput id="receiverStreet" v-model="form.receiverStreet" placeholder="Street" class="w-full" />
      <InputError :message="form.errors.receiverStreet" />
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <InputLabel for="receiverCity" value="City" />
        <TextInput id="receiverCity" v-model="form.receiverCity" placeholder="City" class="w-full" />
        <InputError :message="form.errors.receiverCity" />
      </div>

      <div>
        <InputLabel for="receiverProvince" value="Province" />
        <TextInput id="receiverProvince" v-model="form.receiverProvince" placeholder="Province" class="w-full" />
        <InputError :message="form.errors.receiverProvince" />
      </div>
    </div>

    <div>
      <InputLabel for="receiverZip" value="ZIP Code" />
      <TextInput id="receiverZip" v-model="form.receiverZip" placeholder="ZIP Code" class="w-full" />
      <InputError :message="form.errors.receiverZip" />
    </div>
  </div>

  <!-- Pick-up Branch -->
  <div class="space-y-2">
    <InputLabel for="pickUpBranch" value="Pick-up Branch" />

    <v-select
      v-model="form.pickUpBranch"
      :items="branches"
      variant="outlined"
      density="comfortable"
      class="w-full"
    ></v-select>

    <InputError :message="form.errors.pickUpBranch" />
  </div>



          <!-- Navigation Buttons -->
          <div class="flex justify-between mt-6">
            <PrimaryButton @click="prevStep">Back</PrimaryButton>
            <PrimaryButton @click="nextStep">Next</PrimaryButton>
          </div>
        </div>

        <!-- Step 3: Item Description -->
<div v-if="currentStep === 3" class="space-y-6">
  <h2 class="text-xl flex items-center justify-center font-semibold">Item Description</h2>

  <!-- Advisory Message -->
  <div class="bg-yellow-100 text-yellow-800 p-4 rounded-lg">
    📢 <strong>Advisory:</strong> 
    We only carry packages with a maximum volume of <strong>10 cubic meters</strong> and a weight of <strong>100 kg</strong>. 
    Please ensure your items meet these requirements.
  </div>
  <div>
  <InputLabel for="itemDescription" value="Package Description" />

  <v-textarea
    id="itemDescription"
    v-model="form.itemDescription"
    placeholder="Describe briefly what you need to be delivered."
    variant="outlined"
    rows="3"
    class="w-full"
    density="comfortable"
    
  ></v-textarea>

  <InputError :message="form.errors.itemDescription" />
</div>



  <!-- Dimensions (Height, Width, Length) -->
  <div class="grid grid-cols-3 gap-4">
    <div>
      <InputLabel for="itemHeight" value="Height (m)" />
      <TextInput
        id="itemHeight"
        v-model.number="form.itemHeight"
        class="w-full"
        type="number"
        min="0"
        step="0.01"
      />
      <InputError :message="form.errors.itemHeight" />
    </div>

    <div>
      <InputLabel for="itemWidth" value="Width (m)" />
      <TextInput
        id="itemWidth"
        v-model.number="form.itemWidth"
        class="w-full"
        type="number"
        min="0"
        step="0.01"
      />
      <InputError :message="form.errors.itemWidth" />
    </div>

    <div>
      <InputLabel for="itemLength" value="Length (m)" />
      <TextInput
        id="itemLength"
        v-model.number="form.itemLength"
        class="w-full"
        type="number"
        min="0"
        step="0.01"
      />
      <InputError :message="form.errors.itemLength" />
    </div>
  </div>

  <!-- Total Volume (Live Calculation) -->
  <p>📏 Total Volume: <strong>{{ totalVolume.toFixed(2) }} cubic meters</strong></p>

  <!-- Weight (KG) -->
  <div>
    <InputLabel for="itemWeight" value="Weight (KG)" />
    <TextInput
      id="itemWeight"
      v-model.number="form.itemWeight"
      class="w-full"
      type="number"
      min="0"
      step="0.01"
    />
    <InputError :message="form.errors.itemWeight" />
  </div>

  <!-- Quantity (Boxes/Packages) -->
  <div>
    <InputLabel for="itemQuantity" value="Quantity (Number of Boxes/Packages)" />
    <TextInput
      id="itemQuantity"
      v-model.number="form.itemQuantity"
      class="w-full"
      type="number"
      min="1"
      step="1"
    />
    <InputError :message="form.errors.itemQuantity" />
  </div>

  <!-- Navigation Buttons -->
  <div class="flex justify-between pt-2">
    <PrimaryButton @click="prevStep">Back</PrimaryButton>
    <PrimaryButton @click="submitRequest">Submit</PrimaryButton>
  </div>
</div>
      </div>
    </div>

  </GuestLayout>
</template>