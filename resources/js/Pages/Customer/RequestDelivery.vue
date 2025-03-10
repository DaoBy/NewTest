<script setup>
import { ref, computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import '@mdi/font/css/materialdesignicons.css';


// Reset Form and Go Back to Step 1
const resetForm = () => {
  form.reset(); // Reset the form fields
  currentStep.value = 1; // Go back to Step 1
};


// Form Step Management
const currentStep = ref(1);

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
  paymentMethod: '', // Add paymentMethod field
});

// Available branches
const branches = ['Naga', 'Malabon', 'Legazpi'];



// Calculate Total Volume (Height × Width × Length)
const totalVolume = computed(() => {
  const itemHeight = parseFloat(form.itemHeight) || 0;
  const itemWidth = parseFloat(form.itemWidth) || 0;
  const itemLength = parseFloat(form.itemLength) || 0;
  return itemHeight * itemWidth * itemLength;
});

const totalPrice = computed(() => {
  const baseFee = 500;
  const volumeCost = totalVolume.value * 50;
  const weightCost = parseFloat(form.itemWeight) * 20 || 0;
  const packageCost = parseFloat(form.itemQuantity) * 10 || 0;
  return baseFee + volumeCost + weightCost + packageCost;
});


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

  if (currentStep.value === 4) {
    if (!form.paymentMethod) form.setError('paymentMethod', 'Payment method is required.');
  }

  return !Object.keys(form.errors).length;
};

// Proceed to Next Step
const nextStep = () => {
  if (validateStep()) {
    if (currentStep.value < 5) {
      currentStep.value++;
    }
  }
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
        currentStep.value = 5; // Navigate to Step 5 (Confirmation)
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
    <div v-for="(step, index) in ['Sender Info', 'Receiver Info', 'Item Details', 'Payment', 'Confirmation']" :key="index" class="flex items-center gap-4">
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
    prepend-inner-icon="mdi-map-marker"
    variant="outlined"
    density="comfortable"
    bg-color="bg-white" 
    class="auto" 
    
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
    bg-color="bg-white" 
    class="auto" 
    prepend-inner-icon="mdi-map-marker"
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
        v-model="form.itemHeight"
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
        v-model="form.itemWidth"
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
        v-model="form.itemLength"
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
      v-model="form.itemWeight"
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
      v-model="form.itemQuantity"
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
    <PrimaryButton @click="nextStep">Next</PrimaryButton>
  </div>
</div>



<!-- Step 4: Payment Price Calculator -->
<div v-if="currentStep === 4" class="space-y-6">
  <h2 class="text-xl flex items-center justify-center font-semibold">Payment Price Calculator</h2>

  <!-- Pricing Info -->
  <div class="bg-blue-100 text-blue-800 p-4 rounded-lg">
    💰 <strong>Pricing Policy:</strong>
    - Base Fee: <strong>₱500</strong><br>
    - ₱50 per cubic meter<br>
    - ₱20 per kilogram<br>
    - ₱10 per package
  </div>

  <!-- Live Calculation -->
  <div class="p-4 bg-gray-100 rounded-lg space-y-4">
    <p>📏 <strong>Total Volume:</strong> {{ totalVolume.toFixed(2) }} cubic meters</p>
    <p>⚖️ <strong>Total Weight:</strong> {{ form.itemWeight.toFixed(2) }} kg</p>
    <p>📦 <strong>Quantity:</strong> {{ form.itemQuantity }} packages</p>

    <p class="text-lg font-semibold">
      🧾 <strong>Total Price:</strong> ₱{{ totalPrice.toFixed(2) }}
    </p>
  </div>

<!-- Payment Method -->
<div class="space-y-2">
  <InputLabel for="paymentMethod" value="Select Payment Method" />
  <v-select
    id="paymentMethod"
    v-model="form.paymentMethod"
    :items="['Credit Card', 'Bank Transfer', 'Cash on Delivery']"
    variant="outlined"
    density="comfortable"
    class="auto" 
  ></v-select>
  <InputError :message="form.errors.paymentMethod" />
</div>

  <!-- Navigation Buttons -->
  <div class="flex justify-between pt-2">
    <PrimaryButton @click="prevStep">Back</PrimaryButton>
    <PrimaryButton @click="submitRequest">Submit</PrimaryButton>
  </div>
</div>

<!-- Step 5: Confirmation -->
<div v-if="currentStep === 5" class="space-y-6">
  <h2 class="text-xl flex items-center justify-center font-semibold">Submission Successful</h2>

  <!-- Success Message -->
  <div class="bg-green-100 text-green-800 p-4 rounded-lg text-center">
    <p class="text-lg font-semibold">✅ Your delivery request has been submitted successfully!</p>
    <p class="mt-2">We will call you if your request is granted and ready for receiving in our branch.</p>
  </div>

  <!-- Navigation Buttons -->
  <div class="flex justify-center pt-6">
    <PrimaryButton @click="resetForm">Submit Another Request</PrimaryButton>
  </div>
</div>
      </div>
    </div>
  </GuestLayout>
</template>

