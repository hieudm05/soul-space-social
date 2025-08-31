import { BrowserRouter as Router, Routes, Route } from 'react-router-dom';
import Login from '~/page/Login';

function Routers() {
  return (
    <Router>
      <Routes>
        {/* <Route path="/" element={<Home />} />
        <Route path="/about" element={<About />} /> */}
        <Route path="/login" element={<Login />} />
        {/* <Route path="*" element={<NotFound />} /> */}
      </Routes>
    </Router>
  );
}

export default Routers;
