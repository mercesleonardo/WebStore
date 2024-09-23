export default {
    isMenuOpen: false,
    items: [],

    init() {

    },

    toggleCartMenu() {
        this.isMenuOpen = !this.isMenuOpen;
    },

    closeCartMenu() {
        this.isMenuOpen = false;
    },

    itemsCount() {
        return this.items.reduce((acc, item) => acc + item.quantity, 0);
    },

    async addProduct(productId) {
        try {
            const response = await fetch(`/api/cart/add?id=${productId}`, { method: 'POST' });
            const { items } = await response.json();

            this.items = items;
        } catch (error) {
            console.error(error);
        }
    }
}