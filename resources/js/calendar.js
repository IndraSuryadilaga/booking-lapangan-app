import Alpine from 'alpinejs';

Alpine.data('slotCalendar', (fieldId) => ({
    selectedDate: new Date().toISOString().split('T')[0],
    slots: [],
    selectedSlots: [],
    isLoading: true,
    totalPrice: 0,
    fieldId: fieldId,

    init() {
        this.fetchSlots();
        this.$watch('selectedDate', () => {
            this.selectedSlots = [];
            this.totalPrice = 0;
            this.fetchSlots();
        });
    },

    async fetchSlots() {
      this.isLoading = true;
      try {
        const res = await fetch(`/api/fields/${this.fieldId}/slots?date=${this.selectedDate}`);
        const data = await res.json();
        this.slots = data.slots || [];
      } catch (error) {
        console.error('Gagal mengambil data slot:', error);
        this.slots = [];
      } finally {
        this.isLoading = false;
      }
    },

    toggleSlot(slot) {
      if (slot.status !== 'available') return;
      const idx = this.selectedSlots.findIndex(s => s.start === slot.start);
      if (idx > -1) {
        this.selectedSlots.splice(idx, 1);
      } else {
        this.selectedSlots.push(slot);
      }
      // PERBAIKAN: Gunakan parseFloat() untuk memastikan penjumlahan numerik
      this.totalPrice = this.selectedSlots.reduce((sum, s) => sum + parseFloat(s.price), 0);
    },

    getSlotClass(slot) {
      if (slot.status === 'booked') {
        return 'bg-red-50 border-red-200 text-red-400 cursor-not-allowed';
      }
      if (this.selectedSlots.find(s => s.start === slot.start)) {
        return 'bg-primary-600 border-primary-600 text-white';
      }
      return 'bg-green-50 border-green-300 text-green-700 hover:bg-green-100 cursor-pointer';
    },

    formatPrice(value) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(value);
    }
}));
