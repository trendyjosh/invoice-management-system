export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
    company_name: string;
    company_number: string;
    address_1: string;
    address_2: string;
    city: string;
    county: string;
    postcode: string;
    phone: string;
    bank_name: string;
    bank_acc_no: string;
    bank_sort_code: string;
    invoice_number_format: number;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>
> = T & {
    auth: {
        user: User;
    };
};
