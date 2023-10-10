declare type InvoiceItem = {
    description: string;
    quantity: number;
    unit_price: number;
};

declare type Invoice = {
    user: User;
    customer: Customer;
    date: string;
    due_date: string;
    invoiceItems: Array<InvoiceItem>;
};
