import React, { useState, useContext } from 'react';
import { DataContext } from '../context/DataContext';
import { TextField, MenuItem, FormControl, InputLabel, Select, Box, Button } from '@mui/material';

const FilterComponent = ({ fetchData }) => {
  const { pageSize, setPageSize, filters, setFilters } = useContext(DataContext);
  const [searchTerm, setSearchTerm] = useState('');

  const handlePageSizeChange = (e) => {
    setPageSize(Number(e.target.value));
    fetchData({ search: searchTerm, pageSize: Number(e.target.value) });
  };

  const handleSearchChange = (e) => {
    setSearchTerm(e.target.value);
  };

  const handleSearchSubmit = (e) => {
    e.preventDefault();
    setFilters({ ...filters, search: searchTerm });
    fetchData({ search: searchTerm, pageSize });
  };

  return (
    <Box display="flex" flexDirection="column" gap={2} mb={2}>
      <form onSubmit={(e) => e.preventDefault()}>
        <FormControl variant="outlined" size="small" sx={{ minWidth: 120 }}>
          <InputLabel>Page Size</InputLabel>
          <Select
            value={pageSize}
            onChange={handlePageSizeChange}
            label="Page Size"
          >
            <MenuItem value={5}>5</MenuItem>
            <MenuItem value={10}>10</MenuItem>
            <MenuItem value={20}>20</MenuItem>
            <MenuItem value={50}>50</MenuItem>
          </Select>
        </FormControl>
      </form>

      <form onSubmit={handleSearchSubmit}>
        <Box display="flex" alignItems="center" gap={1}>
          <TextField
            variant="outlined"
            size="small"
            label="Search"
            value={searchTerm}
            onChange={handleSearchChange}
            sx={{ flexGrow: 1 }}
          />
          <Button type="submit" variant="contained" color="primary">
            Search
          </Button>
        </Box>
      </form>
    </Box>
  );
};

export default FilterComponent;
