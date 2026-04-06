<template>
    <form @submit.prevent="submit" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Rule Type</label>
                <select v-model="form.rule_type" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="warn">Warn</option>
                    <option value="mute">Mute</option>
                    <option value="ban">Ban</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Threshold (infractions)</label>
                <input type="number" v-model="form.threshold" min="1" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Duration (minutes, optional)</label>
                <input type="number" v-model="form.duration_minutes" min="1" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
            </div>
            <div class="flex items-center">
                <input type="checkbox" v-model="form.enabled" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" />
                <label class="ml-2 block text-sm text-gray-900">Enabled</label>
            </div>
        </div>
        <div class="flex justify-end space-x-2">
            <button type="button" @click="$emit('cancel')" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md transition duration-150">Cancel</button>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md transition duration-150">Save</button>
        </div>
    </form>
</template>

<script setup>
import { reactive, watch } from 'vue';
import axios from 'axios';

const props = defineProps({ rule: Object });
const emit = defineEmits(['saved', 'cancel']);

const form = reactive({
    rule_type: 'warn',
    threshold: 3,
    duration_minutes: null,
    enabled: true,
});

watch(() => props.rule, (newRule) => {
    if (newRule) Object.assign(form, newRule);
}, { immediate: true });

async function submit() {
    try {
        if (props.rule) {
            await axios.put(`/api/moderation-rules/${props.rule.id}`, form);
        } else {
            await axios.post('/api/moderation-rules', form);
        }
        emit('saved');
    } catch (err) {
        alert('Failed to save rule.');
    }
}
</script>