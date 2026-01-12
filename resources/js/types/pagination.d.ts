export interface PaginationLink {
    url: string;
    label: string;
    active: boolean;
}

interface Paginator {
    current_page: number;
    first_page_url: string;
    from: number;
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number;
}

export interface LengthAwarePaginator extends Paginator {
    last_page: number;
    last_page_url: string | null;
    links: Array<PaginationLink>;
    total: number;
    data: Array<any>;
}
