import React from 'react';
import { DataProvider } from './context/DataContext';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import Layout from './components/Layout';
import UsersPage from './pages/UsersPage';
import ProductDetails from './pages/ProductDetails';
import ProductsPage from './pages/ProductsPage';
import HomePage from './pages/HomePage';

function App() {
  return (
    <DataProvider>
      <Router>
        <Routes>
          <Route path="/" element={<Layout />}>
            <Route index element={<HomePage />} />
            <Route path="users" element={<UsersPage />} />
            <Route path="/products/:id" element={<ProductDetails />} />
            <Route path="products" element={<ProductsPage />} />
          </Route>
        </Routes>
      </Router>
    </DataProvider>
  );
}

export default App;
