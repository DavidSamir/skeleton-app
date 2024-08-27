import React, { createContext, useState } from 'react';

const DataContext = createContext();

const DataProvider = ({ children }) => {
    const [users, setUsers] = useState([]);
    const [products, setProducts] = useState([]);
    const [pageSize, setPageSize] = useState(5);
    const [currentPage, setCurrentPage] = useState(1);

    return (
        <DataContext.Provider value={{ users, setUsers, products, setProducts, pageSize, setPageSize, currentPage, setCurrentPage }}>
            {children}
        </DataContext.Provider>
    );
};

export { DataContext, DataProvider };
