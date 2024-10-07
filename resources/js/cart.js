export default {
    isMenuOpen: false,
    items: [],

    init() {
        this.loadCartItems();
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

            toast('success', 'Produto adicionado ao carrinho');
        } catch (error) {
            console.error(error);

            toast('error', 'Erro ao adicionar o produto ao carrinho');
        }
    },

    async loadCartItems() {
        const response = await fetch('/api/cart');
        const { items } = await response.json();

        this.items = items;
    },

    async removeItem(productId) {
        if (confirm('Deseja realmente remover esse item do carrinho?')) {
            try {
                await fetch(`/api/cart/delete?id=${productId}`, { method: 'DELETE' });

                this.items = this.items.filter(item => item.id !== productId);

                toast('success', 'Produto removido do carrinho');
            } catch (e) {
                console.log(e)

                toast('error', 'Erro ao remover produto do carrinho');
            }
        }
    }
}