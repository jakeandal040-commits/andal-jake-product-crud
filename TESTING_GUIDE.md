# Testing Guide - LavaLust CRUD Application

## 🧪 Complete Testing Workflow

### Phase 1: Initial Setup & Database

**Step 1: Run Database Setup**
```bash
php setup_database.php
```

The script will:
- Create database `lavalust_crud`
- Create `users` table
- Create `products` table
- Offer to insert sample data

**Sample Data Created:**
- Default User: `admin` / `password123`
- Sample Products: 5 products with various prices

---

## 🔐 Phase 2: Authentication Testing

### Test 2.1: Login with Sample Account

1. Go to `http://localhost:8000`
2. You'll be redirected to login page
3. Enter:
   - Username: `admin`
   - Password: `password123`
4. Click Login
5. **Expected:** Redirected to products page

### Test 2.2: New User Registration

1. Click "Register here" link
2. Fill in:
   - Username: `testuser`
   - Email: `test@example.com`
   - Password: `test123456`
   - Confirm Password: `test123456`
3. Click Register
4. **Expected:** Confirm "Registration successful! Please login."
5. Login with new account
6. **Expected:** Redirected to products page

### Test 2.3: Invalid Login

1. Go to login page
2. Enter:
   - Username: `wronguser`
   - Password: `wrongpass`
3. Click Login
4. **Expected:** Error message: "Invalid username or password!"

### Test 2.4: Session Protection

1. Login successfully
2. In browser address bar, navigate directly to: `http://localhost:8000/products`
3. **Expected:** You should see products list (not redirected)
4. Logout
5. Navigate to: `http://localhost:8000/products`
6. **Expected:** Redirected to login page (session expired)

---

## ✅ Phase 3: CRUD Operations Testing

### Test 3.1: READ - View All Products

**Action:**
1. Login to application
2. You should land on products page automatically

**Expected Results:**
- ✅ Page title: "Product Management"
- ✅ Products displayed in table format
- ✅ Columns: ID, Product Name, Description, Price, Quantity, Created At, Actions
- ✅ Sample products visible (if setup script was run)
- ✅ Action buttons visible (Edit, Delete)

**Sample Products Should Show:**
| ID | Product Name | Price | Quantity |
|----|--|--|--|
| 1 | Laptop | ₱45,000.00 | 5 |
| 2 | Mouse | ₱450.00 | 25 |
| 3 | Keyboard | ₱2,500.00 | 10 |
| 4 | Monitor | ₱15,000.00 | 8 |
| 5 | Headphones | ₱8,000.00 | 15 |

---

### Test 3.2: CREATE - Add New Product

**Action:**
1. Click "Add New Product" button
2. Fill form:
   - Product Name: `Gaming Laptop`
   - Description: `High-performance laptop for gaming with RTX 3080`
   - Price: `85000.00`
   - Quantity: `3`
3. Click "Create Product"

**Expected Results:**
- ✅ Form validates (no empty fields)
- ✅ Success message appears (if configured)
- ✅ Redirected to products list
- ✅ New product appears in table
- ✅ New product has correct data
- ✅ Created date is today's date

**Validate in Database:**
```sql
SELECT * FROM products WHERE product_name = 'Gaming Laptop';
```

Should return your newly created product.

---

### Test 3.3: UPDATE - Edit Product

**Action:**
1. Click "Edit" button on any product (e.g., "Gaming Laptop")
2. Modify fields:
   - Product Name: `Gaming Laptop Pro`
   - Price: `95000.00`
   - Quantity: `2`
3. Click "Update Product"

**Expected Results:**
- ✅ Form pre-populated with current values
- ✅ Validation works for modified fields
- ✅ Success message appears
- ✅ Redirected to products list
- ✅ Changes are reflected in table
- ✅ Other fields unchanged

**Validate in Database:**
```sql
SELECT * FROM products WHERE product_name = 'Gaming Laptop Pro';
```

Should show updated price and quantity.

---

### Test 3.4: DELETE - Remove Product

**Action:**
1. Click "Delete" button on your test product
2. Browser will prompt: "Are you sure?"
3. Click "OK" to confirm

**Expected Results:**
- ✅ Confirmation dialog appears
- ✅ Product is removed from table
- ✅ Product no longer appears on page
- ✅ Success message displays (if configured)

**Validate in Database:**
```sql
SELECT COUNT(*) FROM products;
```

Count should decrease by 1.

---

## 🔄 Phase 4: Form Validation Testing

### Test 4.1: Create Product - Field Validation

**Test Missing Fields:**
1. Click "Add New Product"
2. Leave Product Name empty
3. Click "Create Product"
4. **Expected:** Error or form doesn't submit

**Test Invalid Data:**
1. Click "Add New Product"
2. Fill form:
   - Product Name: `Test Product`
   - Description: `Test`
   - Price: `invalid text` (not a number)
   - Quantity: `not a number`
3. Click "Create Product"
4. **Expected:** Validation errors

---

### Test 4.2: Registration - Field Validation

**Test Password Mismatch:**
1. Go to Register page
2. Fill:
   - Password: `password123`
   - Confirm Password: `password456`
3. Click Register
4. **Expected:** Error: Password confirmation doesn't match

**Test Short Password:**
1. Fill:
   - Password: `pass` (less than 6 characters)
3. Click Register
4. **Expected:** Error: Password too short

---

## 🔒 Phase 5: Security Testing

### Test 5.1: Authentication Bypass

**Try to access protected routes:**

1. **Without Login:**
   - Navigate to: `http://localhost:8000/products/create`
   - **Expected:** Redirected to login

2. **After Logout:**
   - Login, then logout
   - Try edit a product URL: `http://localhost:8000/products/edit/1`
   - **Expected:** Redirected to login (session gone)

### Test 5.2: Password Security

1. Register a new user
2. Check database:
   ```sql
   SELECT username, password FROM users;
   ```
3. **Expected:** Passwords are NOT plaintext, they're hashed (long strings starting with $2y$)

### Test 5.3: SQL Injection Attempt

1. Try to create product with:
   - Product Name: `'; DROP TABLE products; --`
   - **Expected:** Treated as literal string, no SQL execution

---

## 📱 Phase 6: UI/UX Testing

### Test 6.1: Responsive Design

1. View on different screen sizes:
   - Desktop (1920px)
   - Tablet (768px)
   - Mobile (375px)
2. **Expected:** 
   - ✅ Navigation bar collapses on mobile
   - ✅ Table scrolls on mobile
   - ✅ Forms are readable
   - ✅ Buttons are clickable

### Test 6.2: Navigation

1. Test all navigation links:
   - Product link in navbar
   - Logout link
   - Register link on login page
2. **Expected:** All links work and page loads correctly

---

## 📊 Phase 7: Data Persistence Testing

### Test 7.1: Data Survives Page Refresh

1. Login and add a product
2. Refresh page (F5)
3. **Expected:** Product still visible

### Test 7.2: Data Survives Logout

1. Login and view products
2. Note product count
3. Logout
4. Login again
5. **Expected:** Same product count, all data intact

### Test 7.3: Database Integrity

Check database:
```sql
-- Count products
SELECT COUNT(*) FROM products;

-- Count users
SELECT COUNT(*) FROM users;

-- View all products with details
SELECT * FROM products ORDER BY created_at DESC;

-- Verify timestamps are set
SELECT id, product_name, created_at FROM products;
```

---

## 🐛 Phase 8: Error Handling

### Test 8.1: Invalid Product ID

1. Try to access: `http://localhost:8000/products/edit/99999`
2. **Expected:** Error message or redirect with "Product not found"

### Test 8.2: Database Disconnect

1. Stop your MySQL server
2. Try to access any page
3. **Expected:** Database connection error (informative error message)

---

## ✨ Phase 9: End-to-End Workflow

**Complete User Journey:**

1. ✅ User accesses `http://localhost:8000`
2. ✅ Redirected to login page
3. ✅ User registers new account
4. ✅ User logs in with new credentials
5. ✅ User sees products list (initially empty if new account)
6. ✅ User adds 3 new products
7. ✅ User sees all 3 products in table
8. ✅ User edits one product
9. ✅ User views updated product
10. ✅ User deletes one product
11. ✅ User confirms only 2 products remain
12. ✅ User logs out
13. ✅ User verifies they're redirected to login
14. ✅ Data persists after logout
15. ✅ User logs back in
16. ✅ User's products are still there

---

## 🎯 Testing Checklist

### Core Functionality
- [ ] Application starts without errors
- [ ] Login page loads
- [ ] Registration page loads
- [ ] Products page loads (when authenticated)

### Authentication
- [ ] Registration works
- [ ] Login works
- [ ] Logout works
- [ ] Session protection works
- [ ] Unauthorized access redirected

### CRUD Operations
- [ ] CREATE: Can add products
- [ ] READ: Can view products
- [ ] UPDATE: Can edit products
- [ ] DELETE: Can delete products

### Validation
- [ ] Required fields validated
- [ ] Email validation works
- [ ] Password confirmation works
- [ ] Form errors displayed

### Security
- [ ] Passwords are hashed
- [ ] SQL injection prevented
- [ ] XSS prevention (HTML escaping)
- [ ] Unauthorized access blocked

### Data
- [ ] Data persists in database
- [ ] Timestamps auto-generated
- [ ] Data survives page refresh
- [ ] Data survives logout/login

### UI
- [ ] Pages render correctly
- [ ] Mobile responsive
- [ ] Navigation works
- [ ] Forms are accessible

---

## 📸 Screenshots for Submission

Take screenshots of:

1. **Login Page**
2. **Registration Success**  
   (success message after register)
3. **Product List (READ)**
4. **Add Product Form (CREATE)**
5. **Edit Product Form (UPDATE)**
6. **Delete Confirmation**
7. **Database Table in Aiven**
   (showing products table with data)

---

## 🔧 Troubleshooting Tests

### If LOGIN FAILS:
- [ ] Check .env database settings
- [ ] Verify users table exists
- [ ] Try sample data: `admin` / `password123`
- [ ] Check latest error in database logs

### If PRODUCTS DON'T SHOW:
- [ ] Verify you're logged in
- [ ] Check products table exists
- [ ] Check database connection in .env
- [ ] Verify migration was run

### If PAGES LOAD SLOWLY:
- [ ] Check database connection
- [ ] Verify MySQL server is running
- [ ] Review server logs for errors

### If VALIDATION DOESN'T WORK:
- [ ] Check form method is POST
- [ ] Verify form fields have correct names
- [ ] Check validation rules in controller

---

## ✅ Test Results Summary

After completing all tests, you should have:

✅ **Authentication Working:**
- Users can register
- Users can login
- Users can logout
- Protected routes working

✅ **CRUD Fully Functional:**
- Products can be created
- Products can be viewed
- Products can be edited
- Products can be deleted

✅ **Database Connected:**
- Data saved in database
- Data retrieved from database
- Relationships working

✅ **Security Implemented:**
- Passwords hashed
- Sessions protected
- Input validated
- Access controlled

✅ **UI Professional:**
- Forms properly styled
- Data presented clearly
- Navigation intuitive
- Mobile responsive

**Ready for Submission! 🎉**
