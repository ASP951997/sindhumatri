# 📋 User Profile Sections - Complete Guide

## 🌐 Live URL Configuration

**Current Configuration:**
- **Development**: `http://localhost:8000`
- **Live URL**: Currently set to `http://localhost` (needs to be updated for production)

**To Update Live URL:**
1. Edit `.env` file
2. Change: `APP_URL=http://localhost`
3. To: `APP_URL=https://your-domain.com`
4. Clear cache: `php artisan config:clear`

---

## 👤 User Profile Section - All Tabs

When logged in, users access their profile at: `http://localhost:8000/user/dashboard`

### **Sidebar Navigation:**
All sections are accessible from the left sidebar menu.

---

## 📑 Complete Tab List & Functionalities

### **1. 🏠 Dashboard**
**URL**: `/user/dashboard`  
**Icon**: 🏠 Home

**Features:**
- ✅ **Overview Statistics**:
  - Remaining Express Interests count
  - Remaining Profile View count
  - Remaining Gallery Image Upload count
  - Shortlisted Members count
  - Interested Members count
  - Ignored Members count
  - Uploaded Stories count
  
- ✅ **Visual Charts**:
  - Profile completion chart
  - Activity graphs
  
- ✅ **Quick Summary**:
  - Current package status
  - Account statistics
  - Recent activity

**Purpose**: Central hub showing user's account status and package limits

---

### **2. 🖼️ Gallery**
**URL**: `/user/gallery`  
**Icon**: 📷 Image

**Features:**
- ✅ **Upload Gallery Images**:
  - Upload limit based on purchased package
  - Image preview before upload
  - Supports: JPG, JPEG, PNG (max 3MB)
  
- ✅ **View Gallery**:
  - Grid display of uploaded images
  - Thumbnail view (381x286px)
  - Full-screen lightbox on click
  
- ✅ **Image Actions**:
  - 🔍 **View Full Size** - Lightbox modal
  - 👤 **Set as Profile Picture** - Make gallery image your profile photo
  - 🗑️ **Delete Image** - Remove from gallery
  
- ✅ **Storage**: `public/assets/uploads/gallery/`
  - Full images: `{filename}.ext`
  - Thumbnails: `thumb_{filename}.ext`

**Purpose**: Manage photo gallery to showcase yourself to potential matches

---

### **3. 📖 Manage Story**
**URL**: `/user/story`  
**Icon**: ⭐ Calendar Star

**Features:**
- ✅ **Create Success Stories**:
  - Share your matrimony journey
  - Upload story image
  - Write detailed narrative
  - Choose story category
  
- ✅ **Edit Stories**:
  - Update existing stories
  - Change images
  - Modify content
  
- ✅ **Delete Stories**:
  - Remove stories you no longer want public
  
- ✅ **Story Status**:
  - Pending approval
  - Approved and published
  - View count tracking

**Purpose**: Share your success story to inspire others and build credibility

---

### **4. 🛒 Purchased Packages**
**URL**: `/user/myPlans`  
**Icon**: 🛍️ Cart Plus

**Features:**
- ✅ **View All Purchased Packages**:
  - Package name
  - Price paid
  - Purchase date
  - Expiration date
  
- ✅ **Search & Filter**:
  - Search by package name
  - Filter by price
  - Filter by date
  
- ✅ **Package Details**:
  - See what features included
  - Check usage limits
  - View validity period
  
- ✅ **History Tracking**:
  - All past purchases
  - Current active packages
  - Expired packages

**Purpose**: Track all matrimony packages you've purchased and their benefits

---

### **5. 💳 Payment History**
**URL**: `/user/fund-history`  
**Icon**: 💰 Money Check

**Features:**
- ✅ **View Transaction History**:
  - All payment transactions
  - Transaction ID
  - Amount paid
  - Payment method used
  - Date and time
  
- ✅ **Payment Status**:
  - ✅ **Complete** - Successfully processed
  - ⏳ **Pending** - Awaiting confirmation
  - ❌ **Cancelled** - Failed or cancelled
  
- ✅ **Search & Filter**:
  - Search by Transaction ID
  - Filter by status (Complete/Pending/Cancel)
  - Filter by date
  
- ✅ **Payment Methods Supported**:
  - Credit/Debit Cards
  - PayPal
  - Razorpay
  - Stripe
  - Bank Transfer
  - UPI
  - And more...

**Purpose**: Track all your payments and transaction history

---

### **6. 📋 Shortlist**
**URL**: `/user/shortlist`  
**Icon**: 📝 List

**Features:**
- ✅ **View Shortlisted Profiles**:
  - All members you've shortlisted
  - Profile photos
  - Basic information
  - Match percentage
  
- ✅ **Quick Actions**:
  - View full profile
  - Send interest
  - Send message
  - Remove from shortlist
  
- ✅ **Search & Filter**:
  - Search by name
  - Filter by criteria
  - Sort by date added
  
- ✅ **Manage List**:
  - Add notes to profiles
  - Organize favorites
  - Quick access to promising matches

**Purpose**: Keep track of interesting profiles you want to review later

---

### **7. ❤️ My Interest**
**URL**: `/user/interest`  
**Icon**: 💗 Heart

**Features:**
- ✅ **Interests Sent**:
  - Profiles you've expressed interest in
  - Status: Pending/Accepted/Declined
  
- ✅ **Interests Received**:
  - Profiles interested in you
  - Accept or decline interests
  - View profile before responding
  
- ✅ **Interest Management**:
  - Track all sent interests
  - Manage received interests
  - See acceptance rate
  
- ✅ **Actions**:
  - Accept interest
  - Decline interest
  - Send message to accepted
  - View detailed profile

**Purpose**: Manage matrimony interests - both sent and received

---

### **8. 🚫 Ignored List**
**URL**: `/user/ignore`  
**Icon**: ⛔ Ban

**Features:**
- ✅ **View Ignored Profiles**:
  - All profiles you've ignored
  - Hidden from your searches
  - Won't appear in recommendations
  
- ✅ **Manage Ignored**:
  - View why you ignored
  - Unignore if you change mind
  - Permanently block profiles
  
- ✅ **Search**:
  - Find specific ignored profiles
  - Filter by date ignored
  
- ✅ **Privacy**:
  - Ignored users won't see your profile
  - You won't see their profile
  - Clean search results

**Purpose**: Hide profiles you're not interested in for better search experience

---

### **9. 🤝 Matched Profile**
**URL**: `/user/matched-profile`  
**Icon**: 🤝 Handshake

**Features:**
- ✅ **AI-Powered Matching**:
  - Profiles matched based on your preferences
  - Compatibility score
  - Match percentage
  
- ✅ **Smart Filters**:
  - Age range compatibility
  - Location preferences
  - Education level
  - Religion and caste
  - Profession matching
  
- ✅ **Match Details**:
  - Why they're a match
  - Common interests
  - Compatibility factors
  
- ✅ **Actions**:
  - View full profile
  - Send interest
  - Add to shortlist
  - Send message

**Purpose**: Discover profiles that best match your partner preferences

---

### **10. ⚙️ Manage Profile**
**URL**: `/user/profile`  
**Icon**: 👤 User Settings

**Features:**
- ✅ **Basic Information**:
  - First name, Last name
  - Date of birth
  - Gender
  - Profile photo upload
  
- ✅ **Contact Details**:
  - Email address
  - Phone number
  - WhatsApp number
  
- ✅ **Physical Attributes**:
  - Height, Weight
  - Body type
  - Complexion
  - Hair color
  - Eye color
  
- ✅ **Education Info**:
  - Educational qualification
  - Institution name
  - Field of study
  - Multiple education records
  
- ✅ **Career Information**:
  - Occupation
  - Company name
  - Annual income
  - Working location
  - Multiple career entries
  
- ✅ **Family Information**:
  - Father's occupation
  - Mother's occupation
  - Number of siblings
  - Family status
  - Family values
  
- ✅ **Present Address**:
  - Current city
  - State/Province
  - Country
  - PIN/ZIP code
  
- ✅ **Permanent Address**:
  - Native place
  - State/Province
  - Country
  
- ✅ **Religious/Spiritual Background**:
  - Religion
  - Caste
  - Sub-caste
  - Gotra
  - Manglik status
  
- ✅ **Astronomic Information**:
  - Date of birth
  - Time of birth
  - Place of birth
  - Zodiac sign
  - Nakshatra (Star)
  
- ✅ **Lifestyle**:
  - Smoking habit
  - Drinking habit
  - Dietary preference (Veg/Non-veg)
  - Health information
  
- ✅ **Hobbies & Interests**:
  - Hobbies selection
  - Music preferences
  - Reading habits
  - Sports interests
  
- ✅ **Language**:
  - Mother tongue
  - Languages known
  - Proficiency level
  
- ✅ **Personal Attitude & Behavior**:
  - Personality traits
  - Nature
  - Affection level
  - Humor sense
  
- ✅ **Partner Expectations**:
  - Age range preference
  - Height preference
  - Education preference
  - Profession preference
  - Location preference
  - Religion/Caste preference
  - Income expectation

**Purpose**: Complete profile management - make your profile attractive and detailed

---

### **11. 💬 Messages**
**URL**: `/user/messenger`  
**Icon**: ✉️ Envelope

**Features:**
- ✅ **Real-Time Chat**:
  - Live messaging with matches
  - Instant message delivery
  - Online/offline status
  
- ✅ **Conversation Management**:
  - View all conversations
  - Unread message count
  - Last message preview
  - Message timestamps
  
- ✅ **Message Actions**:
  - Send text messages
  - View message history
  - Delete conversations
  - Block users
  
- ✅ **Contact List**:
  - All your connections
  - Search contacts
  - Sort by recent activity
  
- ✅ **Notifications**:
  - Push notifications for new messages
  - Sound alerts
  - Desktop notifications

**Purpose**: Communicate with matched profiles and build connections

---

### **12. 🎫 Support Ticket**
**URL**: `/user/ticket`  
**Icon**: 🎧 Headset

**Features:**
- ✅ **Create Support Tickets**:
  - Report issues
  - Ask questions
  - Request assistance
  - Technical support
  
- ✅ **Ticket Management**:
  - View all your tickets
  - Track ticket status:
    - 🟢 **Open** - Newly created
    - 🔵 **Answered** - Admin replied
    - 🟡 **Replied** - You replied back
    - ⚫ **Closed** - Issue resolved
  
- ✅ **Ticket Details**:
  - Ticket number
  - Subject
  - Description
  - Attachments (screenshots)
  - Date created
  - Last reply time
  
- ✅ **Communication**:
  - Reply to admin messages
  - View conversation history
  - Get email notifications
  - Upload supporting documents
  
- ✅ **Priority Levels**:
  - High priority tickets
  - Normal priority
  - Urgent support

**Purpose**: Get help from support team for any issues or questions

---

### **13. 🔐 Change Password**
**URL**: `/user/change-password`  
**Icon**: 🔒 Lock

**Features:**
- ✅ **Password Update**:
  - Enter current password
  - Set new password
  - Confirm new password
  
- ✅ **Security Requirements**:
  - Minimum 6 characters
  - Must match confirmation
  - Current password validation
  
- ✅ **Security Notifications**:
  - Email alert on password change
  - Confirmation message
  
**Purpose**: Update your account password for security

---

### **14. 🔐 2FA Security**
**URL**: `/user/twostep-security`  
**Icon**: 🛡️ User Lock

**Features:**
- ✅ **Two-Factor Authentication**:
  - Enable/disable 2FA
  - QR code generation
  - Google Authenticator support
  
- ✅ **Security Code**:
  - 6-digit verification codes
  - Time-based codes (TOTP)
  - Backup codes
  
- ✅ **Setup Process**:
  - Scan QR code with authenticator app
  - Verify with test code
  - Save backup codes
  
- ✅ **Login Protection**:
  - Requires code on each login
  - Extra security layer
  - Protect against unauthorized access

**Purpose**: Add extra security layer to protect your account

---

### **15. 🚪 Logout**
**Icon**: 🔌 Power Off

**Features:**
- ✅ **Secure Logout**:
  - End current session
  - Clear authentication
  - Redirect to login page

**Purpose**: Safely logout from your account

---

## 📊 Package-Based Features

Many features are **limited by your package**:

### **Package Limits:**
- **Express Interests**: Number of interests you can send
- **Profile Views**: How many full profiles you can view
- **Gallery Upload**: Number of images you can upload
- **Auto Profile Match**: AI matching enabled/disabled

### **Package Types:**
1. **Free Package**: 
   - 100 Express Interests
   - 5 Gallery Photos
   - 0 Profile Views
   - Auto Match enabled

2. **Silver Package** (₹100):
   - 100 Express Interests
   - 10 Gallery Photos
   - 10 Profile Views
   - Auto Match enabled

3. **Gold Package** (₹300):
   - 150 Express Interests
   - 30 Gallery Photos
   - 30 Profile Views
   - Auto Match enabled

4. **Premium Package** (₹500):
   - 200 Express Interests
   - 50 Gallery Photos
   - 50 Profile Views
   - Auto Match enabled

5. **Diamond Package** (₹1000):
   - 500 Express Interests
   - 100 Gallery Photos
   - 200 Profile Views
   - Auto Match enabled

---

## 🗂️ Complete File Structure

### **Gallery Images:**
```
public/assets/uploads/gallery/
├── {uniqueid}.jpg          ← Full image
└── thumb_{uniqueid}.jpg    ← Thumbnail (381x286px)
```

### **User Profile Images:**
```
public/assets/uploads/users/
└── {uniqueid}.png          ← Profile photo (400x400px)
```

### **Story Images:**
```
public/assets/uploads/story/
├── {uniqueid}.jpg          ← Full story image (1176x661px)
└── thumb_{uniqueid}.jpg    ← Thumbnail (381x286px)
```

### **Support Ticket Attachments:**
```
public/assets/uploads/ticket/
└── {uniqueid}.ext          ← Ticket attachments
```

---

## 🔗 Quick Access URLs

| Section | URL | Description |
|---------|-----|-------------|
| **Dashboard** | `/user/dashboard` | Main overview |
| **Gallery** | `/user/gallery` | Photo gallery |
| **Stories** | `/user/story` | Success stories |
| **Packages** | `/user/myPlans` | Purchased packages |
| **Payment History** | `/user/fund-history` | All transactions |
| **Shortlist** | `/user/shortlist` | Saved profiles |
| **My Interest** | `/user/interest` | Sent/received interests |
| **Ignored** | `/user/ignore` | Blocked profiles |
| **Matched Profiles** | `/user/matched-profile` | AI matches |
| **Manage Profile** | `/user/profile` | Edit profile |
| **Messages** | `/user/messenger` | Chat with matches |
| **Support** | `/user/ticket` | Help & support |
| **Change Password** | `/user/change-password` | Update password |
| **2FA Security** | `/user/twostep-security` | Two-factor auth |

---

## 🎯 User Journey Flow

### **Step 1: Complete Profile**
1. Login → Dashboard
2. Click "Manage Profile"
3. Fill all sections (Basic, Education, Career, etc.)
4. Upload profile photo
5. Upload gallery images

### **Step 2: Find Matches**
1. Browse "Matched Profiles" (AI recommendations)
2. Search for specific preferences
3. View member profiles
4. Shortlist interesting profiles

### **Step 3: Express Interest**
1. Click "Send Interest" on profile
2. Wait for acceptance
3. View status in "My Interest" tab

### **Step 4: Connect**
1. When interest accepted → Send message
2. Chat via "Messages" tab
3. Exchange contact information
4. Meet in person

### **Step 5: Upgrade & Extend**
1. Purchase packages when limits reached
2. View in "Purchased Packages"
3. Track payments in "Payment History"

---

## 📱 Mobile Access

All sections are **mobile responsive** and accessible on:
- 📱 Smartphones
- 💻 Tablets
- 🖥️ Desktop computers

---

## 🔔 Notifications

Users receive notifications for:
- ✅ New interest received
- ✅ Interest accepted
- ✅ New message received
- ✅ Profile view
- ✅ Shortlist by others
- ✅ Package expiring soon
- ✅ Payment successful
- ✅ Support ticket replied

---

## 🛡️ Privacy & Security

### **Privacy Controls:**
- ✅ Control who can view your profile
- ✅ Hide contact details
- ✅ Block/ignore unwanted users
- ✅ Report inappropriate behavior

### **Security Features:**
- ✅ 2FA authentication
- ✅ Password change notifications
- ✅ Login activity tracking
- ✅ Session management

---

## 📞 Support

**Need Help?**
- 📧 Email: info@sindhumatri.com
- 📱 Phone: 9823668878
- 🎫 Support Ticket: `/user/ticket/create`
- 📍 Office: SAI PLAZA, SAI CHOWK, PIMPRI-PUNE-411017

---

## 💡 Pro Tips

### **For Better Results:**
1. ✅ **Complete your profile 100%** - More matches
2. ✅ **Upload 5-10 gallery images** - Build trust
3. ✅ **Write a good introduction** - Stand out
4. ✅ **Be active daily** - Better visibility
5. ✅ **Respond to interests quickly** - Show seriousness
6. ✅ **Keep profile updated** - Accurate information
7. ✅ **Use quality photos** - First impression matters

### **Package Management:**
1. ✅ Start with **Free Package** to explore
2. ✅ Upgrade to **Silver/Gold** when serious
3. ✅ **Premium/Diamond** for maximum exposure
4. ✅ Track usage in **Dashboard**
5. ✅ Renew before expiry

### **Safety Tips:**
1. ⚠️ Never share financial information
2. ⚠️ Meet in public places first
3. ⚠️ Verify profile authenticity
4. ⚠️ Report suspicious profiles
5. ⚠️ Use platform messaging initially

---

## 📈 Feature Comparison

| Feature | Free | Silver | Gold | Premium | Diamond |
|---------|------|--------|------|---------|---------|
| **Express Interest** | 100 | 100 | 150 | 200 | 500 |
| **Gallery Photos** | 5 | 10 | 30 | 50 | 100 |
| **Profile Views** | 0 | 10 | 30 | 50 | 200 |
| **Auto Match** | ✅ | ✅ | ✅ | ✅ | ✅ |
| **Messaging** | ✅ | ✅ | ✅ | ✅ | ✅ |
| **Stories** | ✅ | ✅ | ✅ | ✅ | ✅ |
| **Support** | ✅ | ✅ | ✅ | ✅ | ✅ |
| **Price** | Free | ₹100 | ₹300 | ₹500 | ₹1000 |

---

## ✅ Summary

The user profile section provides **15 comprehensive tabs** covering:

1. ✅ **Overview** - Dashboard with statistics
2. ✅ **Media** - Gallery management
3. ✅ **Stories** - Success story sharing
4. ✅ **Billing** - Packages & payments
5. ✅ **Connections** - Shortlist, interests, matches
6. ✅ **Communication** - Messages & chat
7. ✅ **Profile** - Complete profile management
8. ✅ **Support** - Help tickets
9. ✅ **Security** - Password & 2FA

**Everything a user needs to find their perfect match!** 💑

---

**Date**: October 8, 2025  
**Application**: SPMO Matrimony  
**Platform**: Laravel-based Matrimony Platform  
**Status**: ✅ Fully Functional








