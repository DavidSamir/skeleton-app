import React, { useContext, useEffect, useState } from 'react';
import DataTable from '../components/DataTable';
import FilterComponent from '../components/FilterComponent';
import PaginationComponent from '../components/PaginationComponent';
import { DataContext } from '../context/DataContext';
import axios from 'axios';
import { CircularProgress, Typography, Box, Container } from '@mui/material';

const UsersPage = () => {
  const { users, setUsers, pageSize, currentPage, filters, setCurrentPage } = useContext(DataContext);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  const fetchUsers = async ({ search = '', pageSize, currentPage }) => {
    setLoading(true);
    setError(null);

    if (!Number.isInteger(currentPage) || currentPage < 1) {
      setError('Invalid page number.');
      setLoading(false);
      return;
    }

    try {
      const searchQuery = search ? `/search?q=${search}` : `?limit=${pageSize}&skip=${(currentPage - 1) * pageSize}`;
      const response = await axios.get(
        `https://dummyjson.com/users${searchQuery}`
      );

      const filteredUsers = response.data.users.map(user => ({
        image: user.image,
        "First Name": user.firstName,
        "Last Name": user.lastName,
        age: user.age,
        gender: user.gender,
        phone: user.phone,
        "Birth Date": user.birthDate,
        role: user.role,
      }));

      setUsers(filteredUsers);
    } catch (error) {
      setError('Failed to fetch users.');
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    if (Number.isInteger(currentPage) && currentPage > 0) {
      fetchUsers({ search: filters.search, pageSize, currentPage });
    } else {
      setError('Invalid page number.');
      setCurrentPage(1); 
    }
  }, [filters.search, pageSize, currentPage, setUsers, setCurrentPage]);

  return (
    <Container>
      <Typography variant="h4" gutterBottom>
        Users Page
      </Typography>
      <Box mb={2}>
        <FilterComponent fetchData={fetchUsers} />
      </Box>
      {loading ? (
        <Box display="flex" justifyContent="center" mt={4}>
          <CircularProgress />
        </Box>
      ) : error ? (
        <Typography color="error" align="center" mt={4}>
          {error}
        </Typography>
      ) : (
        <DataTable data={users} />
      )}
      <Box mt={4}>
        <PaginationComponent />
      </Box>
    </Container>
  );
};

export default UsersPage;
