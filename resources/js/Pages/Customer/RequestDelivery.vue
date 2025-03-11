<script setup>
import { ref, computed, onMounted } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import axios from 'axios';

// Form Step Management
const currentStep = ref(1);

// Reset Form and Go Back to Step 1
const resetForm = () => {
  form.reset(); // Reset the form fields
  currentStep.value = 1; // Go back to Step 1
};

// Fetch price matrix for calculation
const priceMatrix = ref({
  base_fee: 500,
  volume_rate: 50,
  weight_rate: 20,
  package_rate: 10,
});

// Fetch the price matrix from the backend
const fetchPriceMatrix = async () => {
  try {
    const response = await axios.get('/price-matrix');
    priceMatrix.value = response.data.priceMatrix;
  } catch (error) {
    console.error('Failed to fetch price matrix:', error);
  }
};

// Fetch the price matrix when the component is mounted
onMounted(fetchPriceMatrix);

// Form Data (Supports Multiple Packages)
const form = useForm({
  senderType: 'individual',
  senderFullName: '',
  senderCompanyName: '',
  senderMobile: '',
  senderEmail: '',
  senderStreet: '',
  senderCity: '',
  senderProvince: '',
  senderZip: '',
  dropOffBranch: '',
  receiverType: 'individual',
  receiverFullName: '',
  receiverCompanyName: '',
  receiverMobile: '',
  receiverEmail: '',
  receiverStreet: '',
  receiverCity: '',
  receiverProvince: '',
  receiverZip: '',
  pickUpBranch: '',
  packages: [
    {
      description: '',
      height: '',
      width: '',
      length: '',
      weight: '',
      quantity: 1,
      value: '',
    },
  ],
  paymentMethod: '',
  totalPrice: 0, // This will be calculated dynamically
});


// Available branches
const branches = ['Naga', 'Malabon', 'Legazpi'];

// Helper function to sanitize numbers
const sanitizeNumber = (value) => parseFloat(value) || 0;

// Calculate Total Price (using dynamic price matrix)
const totalPrice = computed(() => {
  if (!priceMatrix.value) return 0;

  return form.packages.reduce((sum, pkg) => {
    const volume = sanitizeNumber(pkg.height) * sanitizeNumber(pkg.width) * sanitizeNumber(pkg.length);
    const weightCost = sanitizeNumber(pkg.weight) * priceMatrix.value.weight_rate;
    const volumeCost = volume * priceMatrix.value.volume_rate;
    const packageCost = sanitizeNumber(pkg.quantity) * priceMatrix.value.package_rate;

    return sum + priceMatrix.value.base_fee + volumeCost + weightCost + packageCost;
  }, 0);
});

// Validate Current Step
const validateStep = () => {
  form.clearErrors();

  if (currentStep.value === 1) {
    if (!form.senderFullName) form.setError('senderFullName', 'Full Name is required.');
    if (!form.senderMobile) form.setError('senderMobile', 'Mobile number is required.');
    if (!form.senderEmail) form.setError('senderEmail', 'Email is required.');
    if (!form.senderStreet) form.setError('senderStreet', 'Street is required.');
    if (!form.senderCity) form.setError('senderCity', 'City is required.');
    if (!form.senderProvince) form.setError('senderProvince', 'Province is required.');
    if (!form.senderZip) form.setError('senderZip', 'ZIP Code is required.');
    if (!form.dropOffBranch) form.setError('dropOffBranch', 'Drop-off branch is required.');

    if (form.senderType === 'company' && !form.senderCompanyName) {
      form.setError('senderCompanyName', 'Company Name is required.');
    }
  }

  if (currentStep.value === 2) {
    if (!form.receiverFullName) form.setError('receiverFullName', 'Full Name is required.');
    if (!form.receiverMobile) form.setError('receiverMobile', 'Mobile number is required.');
    if (!form.receiverEmail) form.setError('receiverEmail', 'Email is required.');
    if (!form.receiverStreet) form.setError('receiverStreet', 'Street is required.');
    if (!form.receiverCity) form.setError('receiverCity', 'City is required.');
    if (!form.receiverProvince) form.setError('receiverProvince', 'Province is required.');
    if (!form.receiverZip) form.setError('receiverZip', 'ZIP Code is required.');
    if (!form.pickUpBranch) form.setError('pickUpBranch', 'Pick-up branch is required.');

    if (form.receiverType === 'company' && !form.receiverCompanyName) {
      form.setError('receiverCompanyName', 'Company Name is required.');
    }
  }

  if (currentStep.value === 3) {
    form.packages.forEach((pkg, index) => {
      if (!pkg.description) form.setError(`packages.${index}.description`, 'Package description is required.');
      if (!pkg.height) form.setError(`packages.${index}.height`, 'Height is required.');
      if (!pkg.width) form.setError(`packages.${index}.width`, 'Width is required.');
      if (!pkg.length) form.setError(`packages.${index}.length`, 'Length is required.');
      if (!pkg.weight) form.setError(`packages.${index}.weight`, 'Weight is required.');
      if (!pkg.quantity) form.setError(`packages.${index}.quantity`, 'Quantity is required.');
      if (!pkg.value) form.setError(`packages.${index}.value`, 'Package value is required.');

      // Enforce package limits
      const volume = sanitizeNumber(pkg.height) * sanitizeNumber(pkg.width) * sanitizeNumber(pkg.length);
      if (volume > 10) form.setError(`packages.${index}.height`, 'Package volume exceeds 10 m³.');
      if (pkg.weight > 100) form.setError(`packages.${index}.weight`, 'Package weight exceeds 100 kg.');
    });
  }

  return !Object.keys(form.errors).length;
};

// Add/Remove Package
const addPackage = () => {
  form.packages.push({
    description: '',
    height: '',
    width: '',
    length: '',
    weight: '',
    quantity: 1,
    value: '',
  });
};

const removePackage = (index) => {
  if (form.packages.length > 1) {
    form.packages.splice(index, 1);
  }
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
    form.totalPrice = totalPrice.value; // Set the total price before submission
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
    <InputLabel value="Sender Type" class="mb-2" />
    <div class="flex gap-6">
      <label class="flex items-center">
        <input type="radio" value="individual" v-model="form.senderType" class="mr-2" />
        Individual
      </label>
      <label class="flex items-center">
        <input type="radio" value="company" v-model="form.senderType" class="mr-2" />
        Company
      </label>
    </div>
  </div>

  
  <!-- Company Fields (if Company is selected) -->
  <div v-if="form.senderType === 'company'" class="space-y-2">
    <InputLabel for="senderCompanyName" value="Company Name" />
    <TextInput id="senderCompanyName" v-model="form.senderCompanyName" class="w-full" />
    <InputError :message="form.errors.senderCompanyName" />
  </div>

  <!-- Shared Fields (For Both Individual and Company) -->
  <div class="space-y-4">
   
    <div>
  <InputLabel for="senderFullName" value="Full Name" />
  <TextInput id="senderFullName" v-model="form.senderFullName" class="w-full" />
  <InputError :message="form.errors.senderFullName" />
    </div>

    <div>
  <InputLabel for="senderEmail" value="Sender Email Adress" />
  <TextInput id="senderEmail" v-model="form.senderEmail" class="w-full" />
  <InputError :message="form.errors.senderEmail" />
    </div>


    <div>
      <InputLabel for="senderMobile" value="Mobile Number" />
      <TextInput id="senderMobile" v-model="form.senderMobile" class="w-full" />
      <InputError :message="form.errors.senderMobile" />
    </div>
  </div>

  <!-- Address Fields -->
  <div class="space-y-4">
    <InputLabel :value="form.senderType === 'company' ? 'Company Address' : 'Full Address'" />

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

  <!-- Customer Type (Radio Buttons) -->
  <div>
    <InputLabel value="receiver Type" class="mb-2" />
    <div class="flex gap-6">
      <label class="flex items-center">
        <input type="radio" value="individual" v-model="form.receiverType" class="mr-2" />
        Individual
      </label>
      <label class="flex items-center">
        <input type="radio" value="company" v-model="form.receiverType" class="mr-2" />
        Company
      </label>
    </div>
  </div>

  <!-- Company Fields (if Company is selected) -->
  <div v-if="form.receiverType === 'company'" class="space-y-2">
    <InputLabel for="receiverCompanyName" value="Company Name" />
    <TextInput id="receiverCompanyName" v-model="form.receiverCompanyName" class="w-full" />
    <InputError :message="form.errors.receiverCompanyName" />
  </div>


  <div>
  <InputLabel for="receiverFullName" value="Full Name" />
  <TextInput id="receiverFullName" v-model="form.receiverFullName" class="w-full" />
  <InputError :message="form.errors.receiverFullName" />
</div>

<div>
  <InputLabel for="receiverEmail" value="Receiver Email Adress" />
  <TextInput id="receiverEmail" v-model="form.receiverEmail" class="w-full" />
  <InputError :message="form.errors.receiverEmail" />
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
    📢 <strong>Advisory:</strong> We only carry packages with a maximum volume of
    <strong>10 cubic meters</strong> and a weight of <strong>100 kg</strong> per package.
    Ensure your items meet these requirements.
  </div>

  <!-- Dynamic Package Input -->
  <div v-for="(pkg, index) in form.packages" :key="index" class="border p-4 rounded-lg space-y-4">
    <h3 class="text-lg font-semibold">📦 Package {{ index + 1 }}</h3>

    <div>
      <InputLabel :for="`description-${index}`" value="Package Description" />
      <v-textarea
        :id="`description-${index}`"
        v-model="pkg.description"
        placeholder="Describe briefly what you need to be delivered."
        variant="outlined"
        rows="3"
        class="w-full"
        density="comfortable"
      ></v-textarea>
      <InputError :message="form.errors[`packages.${index}.description`]" />
    </div>

    <!-- Dimensions & Package Value -->
    <div class="grid grid-cols-3 gap-4">
      <div>
        <InputLabel :for="`value-${index}`" value="Package Value (₱)" />
        <v-text-field
          :id="`value-${index}`"
          v-model.number="pkg.value"
          class="w-full"
          type="number"
          min="0"
          step="0.01"
          variant="outlined"
          density="comfortable"
        ></v-text-field>
        <InputError :message="form.errors[`packages.${index}.value`]" />
      </div>

      <div>
        <InputLabel :for="`height-${index}`" value="Height (m)" />
        <v-text-field
          :id="`height-${index}`"
          v-model.number="pkg.height"
          class="w-full"
          type="number"
          min="0"
          step="0.01"
          variant="outlined"
          density="comfortable"
        ></v-text-field>
        <InputError :message="form.errors[`packages.${index}.height`]" />
      </div>

      <div>
        <InputLabel :for="`width-${index}`" value="Width (m)" />
        <v-text-field
          :id="`width-${index}`"
          v-model.number="pkg.width"
          class="w-full"
          type="number"
          min="0"
          step="0.01"
          variant="outlined"
          density="comfortable"
        ></v-text-field>
        <InputError :message="form.errors[`packages.${index}.width`]" />
      </div>

      <div>
        <InputLabel :for="`length-${index}`" value="Length (m)" />
        <v-text-field
          :id="`length-${index}`"
          v-model.number="pkg.length"
          class="w-full"
          type="number"
          min="0"
          step="0.01"
          variant="outlined"
          density="comfortable"
        ></v-text-field>
        <InputError :message="form.errors[`packages.${index}.length`]" />
      </div>

      <div>
        <InputLabel :for="`weight-${index}`" value="Weight (kg)" />
        <v-text-field
          :id="`weight-${index}`"
          v-model.number="pkg.weight"
          class="w-full"
          type="number"
          min="0"
          step="0.01"
          variant="outlined"
          density="comfortable"
        ></v-text-field>
        <InputError :message="form.errors[`packages.${index}.weight`]" />
      </div>

      <div>
        <InputLabel :for="`quantity-${index}`" value="Quantity" />
        <v-text-field
          :id="`quantity-${index}`"
          v-model.number="pkg.quantity"
          class="w-full"
          type="number"
          min="1"
          step="1"
          variant="outlined"
          density="comfortable"
        ></v-text-field>
        <InputError :message="form.errors[`packages.${index}.quantity`]" />
      </div>
    </div>

    <!-- Remove Package Button -->
    <div class="text-right">
      <SecondaryButton v-if="form.packages.length > 1" @click="removePackage(index)">
        ➖ Remove Package
      </SecondaryButton>
    </div>
  </div>

  <!-- Add Package Button -->
  <div>
    <PrimaryButton @click="addPackage">➕ Add Another Package</PrimaryButton>
  </div>

  <!-- Navigation Buttons -->
  <div class="flex justify-between pt-4">
    <PrimaryButton @click="prevStep">Back</PrimaryButton>
    <PrimaryButton @click="nextStep">Next</PrimaryButton>
  </div>
</div>

<!-- Step 4: Payment Price Calculator -->
<div v-if="currentStep === 4" class="space-y-6">
  <h2 class="text-xl flex items-center justify-center font-semibold">Payment Price Calculator</h2>

  <!-- Pricing Info -->
  <div class="bg-blue-100 text-blue-800 p-4 rounded-lg">
    💰 <strong>Pricing Policy:</strong><br>
    - Base Fee: <strong>₱{{ priceMatrix.base_fee }}</strong><br>
    - ₱{{ priceMatrix.volume_rate }} per cubic meter<br>
    - ₱{{ priceMatrix.weight_rate }} per kilogram<br>
    - ₱{{ priceMatrix.package_rate }} per package
  </div>

  <!-- Package Summary -->
  <div class="p-4 bg-gray-100 rounded-lg space-y-4">
    <template v-for="(pkg, index) in form.packages" :key="index">
      <p>📦 <strong>Package {{ index + 1 }}:</strong></p>
      <p>📏 Volume: {{ (sanitizeNumber(pkg.height) * sanitizeNumber(pkg.width) * sanitizeNumber(pkg.length)).toFixed(2) }} m³</p>
      <p>⚖️ Weight: {{ pkg.weight.toFixed(2) }} kg</p>
      <p>📦 Quantity: {{ pkg.quantity }}</p>
      <hr />
    </template>

    <p class="text-lg font-semibold">🧾 <strong>Total Price:</strong> ₱{{ totalPrice.toFixed(2) }}</p>
  </div>

  <!-- Payment Method -->
  <div class="space-y-2">
    <InputLabel for="paymentMethod" value="Select Payment Method" />
    <v-select
      id="paymentMethod"
      v-model="form.paymentMethod"
      :items="['cash','card']"
      variant="outlined"
      density="comfortable"
      class="auto"
    ></v-select>
    <InputError :message="form.errors.paymentMethod" />
  </div>

  <!-- Navigation Buttons -->
  <div class="flex justify-between pt-4">
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
  <p class="mt-2">Sender: {{ form.senderFullName }}</p>
  <p class="mt-2">Receiver: {{ form.receiverFullName }}</p>
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