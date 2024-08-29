import React, { createContext, useState } from 'react';

export const DataContext = createContext();

export const DataProvider = ({ children }) => {
    const [users, setUsers] = useState([]);
    const [products, setProducts] = useState([]);
    const [pageSize, setPageSize] = useState(10);
    const [currentPage, setCurrentPage] = useState(1);
    const [filters, setFilters] = useState({ search: '' });

    return (
        <DataContext.Provider
            value={{
                users,
                setUsers,
                pageSize,
                products,
                setProducts,
                setPageSize,
                currentPage,
                setCurrentPage,
                filters,
                setFilters,
            }}
        >
            {children}
        </DataContext.Provider>
    );
};
