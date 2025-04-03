class CurrencyFormatter {
    constructor() {
        this.baseUrl = '/api';
    }

    async formatAmount(amount) {
        try {
            const response = await fetch(`${this.baseUrl}/currency/format/${amount}`);
            const data = await response.json();
            
            if (data.success) {
                return data.data.formatted_amount;
            }
            throw new Error('Failed to format amount');
        } catch (error) {
            console.error('Error formatting currency:', error);
            return amount; // Return original amount if formatting fails
        }
    }

    // Helper method to format multiple amounts in a container
    async formatAmountsInContainer(container, selector = '[data-amount]') {
        const elements = container.querySelectorAll(selector);
        
        for (const element of elements) {
            const amount = parseFloat(element.getAttribute('data-amount'));
            if (!isNaN(amount)) {
                const formattedAmount = await this.formatAmount(amount);
                element.textContent = formattedAmount;
            }
        }
    }
}

// Initialize the formatter
const currencyFormatter = new CurrencyFormatter();

// Example usage:
// 1. Format a single amount:
// currencyFormatter.formatAmount(100).then(formatted => console.log(formatted));

// 2. Format all amounts in a container:
// currencyFormatter.formatAmountsInContainer(document.querySelector('.price-container')); 