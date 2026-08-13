# Profile Mfg Inventory and Production System

## Current-System Analysis and Proposed Improvements

**Document purpose:** Provide a customer-facing overview of the current inventory application, the business functions it supports, and the potential additions and improvements identified for a future system.

**Document status:** Planning-level analysis. The proposed capabilities and phases are intended to support requirements discussions; they are not a final technical design, implementation commitment, or project estimate.

**Executive summary:** [Custom Inventory and Production Platform — Executive Overview](profile-mfg-custom-system-executive-overview.md)

**Related research:** [Commercial Manufacturing Software Fit Analysis](commercial-manufacturing-software-fit-analysis.md)

---

## 1. Executive Overview

The current Profile Mfg application is a focused customer-order and finished-goods inventory system. It helps users maintain customers and parts, record order demand, adjust inventory, scan serialized boxes into and out of inventory, and review daily or weekly operational reports.

At a high level, the current application helps answer:

- What customer parts does Profile Mfg produce?
- What orders are open, shorted, due, closed, or cancelled?
- What quantities are expected to ship and when?
- What finished-goods boxes have been scanned into inventory?
- What boxes have been scanned as shipped?
- What inventory adjustments and production additions have been recorded?

The application is not currently a complete manufacturing execution system, warehouse management system, material requirements planning system, or enterprise resource planning system. Functions such as raw-material planning, production work orders, bills of material, equipment maintenance, warehouse locations, subcontractor inventory, labor tracking, and formal shipment management are not part of the current core system.

The proposed future system could preserve the existing order and finished-goods functions while expanding them into a connected operational platform covering:

- Customer demand and order fulfillment
- Part engineering and assemblies
- Production scheduling and work-in-process visibility
- Raw-material inventory and purchasing
- Production lines, equipment, and maintenance
- Warehouse and shop-floor locations
- Subcontracted operations
- Shipment documentation and photographs
- Mobile scanning and location identification
- Automated reports, alerts, and scheduled delivery

The proposed inventory suite would be hosted within the reusable **Login 2.0** business-management platform. Login 2.0 would provide the shared application foundation—including authentication, access control, dashboards, notifications, audit infrastructure, background processing, integrations, and application management—while the inventory suite would provide Profile Mfg's manufacturing, inventory, production, purchasing, maintenance, and shipping business functions.

This division allows the project to build specialized operational capabilities without recreating common platform services inside each module.

---

## 2. Current System at a Glance

### 2.1 Customers

The current system allows users to add, search, view, and modify customer records. Customer information includes:

- Business name
- Primary contact
- Billing address
- Shipping address
- Telephone and fax
- Email address
- Shipping instructions
- Active or obsolete status

The current structure is centered on one primary contact and one billing and shipping address per customer. Multiple contacts, multiple ship-to locations, communication history, and customer self-service are not currently evident.

### 2.2 Parts

The part master connects Profile Mfg's internal part identity with the customer's part identity. It currently stores:

- Internal Profile/PMI part number
- Customer part number
- Customer association
- Description
- Program
- Profile
- Pieces per box
- Production line number
- Material description
- Weight in pounds per piece
- Blueprint revision or level
- Part status
- Additional notes or descriptive fields

Part statuses include classifications such as Active, WIP, Service, and Obsolete.

The existing weight field is used to display part weight and calculate total box weight. It is not currently used to calculate raw-material requirements, process waste, production yield, or manufacturing cost.

The application also supports uploading and displaying a JPG image associated with a part. This is useful for visual reference, but it does not provide revision-controlled drawing management, document approval, or a broader engineering document library.

### 2.3 Orders

The current system records customer demand using:

- Customer
- Part
- Original quantity
- Remaining quantity
- Due date
- Notes
- Order status

Order statuses include:

- Open
- Shorted
- Closed
- Cancelled

Users can enter orders, view open demand, modify quantities and due dates, cancel orders, and close or partially fulfill orders.

Each current order record effectively represents demand for one part. The system does not have a formal customer-order header containing a customer PO number, multiple order lines, order-level shipping information, or a complete fulfillment history.

### 2.4 Quantity-Based Inventory

The application maintains an accounting-style inventory history of additions and subtractions by part. Inventory adjustments record:

- Part
- Quantity added
- Quantity subtracted
- Notes
- User
- Date and time

Single-part and multiple-part adjustment screens are available. Closing an order also records a quantity subtraction.

The application additionally stores a calculated total on the part record. Because the transaction history and stored total are maintained separately, the stored total can become different from a recalculation of the underlying transactions.

### 2.5 Serialized Box Inventory and Scanning

The scanning functions track finished-goods boxes using:

- Customer part number
- Manufacturing date
- Serial number
- Current status
- Inventory date
- Ship date
- Scan history

A scanned record generally represents one physical box. The part's pieces-per-box value is used when reports convert box counts into estimated piece totals.

The current scanning workflow supports:

- Scanning a box into inventory
- Scanning a box as shipped
- Viewing scanned inventory by part
- Reviewing daily scanned and shipped activity

The serialized inventory process and the quantity-based accounting inventory process are separate. A box scanned as shipped is not formally linked to a shipment or order line, and administratively closing an order does not prove that the corresponding serialized boxes were scanned out.

### 2.6 Shipping and Order Fulfillment

The current system has two related but separate fulfillment activities:

1. An order can be administratively closed or marked shorted, which changes the remaining demand and records an inventory transaction.
2. Serialized boxes can be scanned out as shipped, which changes their physical inventory status.

There is no formal shipment record connecting the customer order, fulfilled order lines, serialized boxes, carrier, tracking information, packing documentation, and shipment photographs.

### 2.7 Users and Access

The application uses session-based login and broad access levels, including:

- Administrator
- Inventory Control
- Order Entry

The user administration area supports adding, viewing, and modifying user accounts. Password recovery is also present.

A future system would benefit from modern password protection, consistent permission enforcement, account activation and deactivation, more granular roles, and a complete administrative audit trail.

### 2.8 PPAP Tracking

The application contains a separate PPAP register that tracks:

- PMI job number
- Customer
- PO number
- Description
- Date received
- Date due
- Job code
- Shipped date
- Invoice number
- Paid date

PPAP records can be added, searched, viewed, modified, and deleted. The current feature operates as a standalone register rather than a complete quality-document workflow with attachments, revisions, approvals, submissions, or customer signoff.

---

## 3. Current Operational Flow

The current process can be summarized as follows:

1. A customer is created.
2. Parts are created for that customer with both internal and customer part numbers.
3. Customer demand is entered as individual part orders with quantities and due dates.
4. Finished boxes may be scanned into serialized inventory.
5. Planning reports show open and shorted demand by customer, part, and due date.
6. Orders are administratively closed or shorted, creating accounting inventory transactions.
7. Physical boxes are separately scanned out as shipped.

This workflow meets several important daily needs, but it does not create one continuous record from customer order through production, box creation, warehouse location, allocation, shipment, and delivery.

---

## 4. Current Report Portfolio

### 4.1 Daily/Weekly Shipping Schedule

Shows open and shorted demand by active customer and part. The report includes:

- Upcoming business-day quantities
- Aggregated `+2 Weeks` demand
- Aggregated `+6 Weeks` demand
- Past-due quantities
- Customer shipping instructions

This report is primarily a demand and shipping-planning view.

### 4.2 Daily Order Schedule

Shows orders due on a selected date, grouped by customer. It includes:

- Customer
- Internal and customer part information
- Due quantity
- Full-box calculation
- Remaining pieces that do not make a full box

### 4.3 Scanning Inventory Status

Provides separate inventory-status views for:

- Active parts
- WIP parts
- Active and WIP parts
- Non-active parts

These reports combine scanned inventory information, scanning-related manual adjustments, upcoming order demand, and latest scan information.

### 4.4 Inventory Scanned

Shows serialized boxes scanned into inventory on a selected day, including:

- Customer part number
- Manufacturing date
- Serial number
- Scan time
- Total boxes
- Estimated total pieces

### 4.5 Inventory Shipped

Shows serialized boxes marked as shipped on a selected day, including:

- Customer part number
- Manufacturing date
- Serial number
- Shipment or scan time
- Total boxes
- Estimated total pieces

### 4.6 Inventory Transactions

Shows recent accounting inventory transactions, including:

- Part
- Quantity added
- Quantity subtracted
- Notes
- User
- Date and time

The current report is limited to the most recent 3,000 transactions.

### 4.7 Production Totals

Shows cumulative inventory additions by customer and part. Despite its title, this is not a date-filtered production-performance report. It does not currently measure production by day, shift, line, machine, work order, employee assignment, or actual run.

### 4.8 Part-Level Order Visibility

The individual part page shows associated open and shorted orders, quantities, statuses, and due dates. This provides direct demand visibility from the part record.

### 4.9 PPAP List and Search

Provides sorting and searching across PPAP job, customer, PO, milestone date, invoice, and payment information.

### 4.10 Reporting Consideration

The application currently maintains several operational perspectives:

- Serialized physical inventory
- Quantity-based accounting transactions
- Stored part totals
- Open-order demand

Different reports read from different sources. As a result, totals from two reports may not always represent the same business definition of inventory. A future system should define one authoritative calculation for terms such as:

- On hand
- Available
- Allocated
- WIP
- Produced
- Shipped
- Scrapped
- Past due

---

## 5. Login 2.0 Platform Foundation

### 5.1 Role of the Platform

Login 2.0 is being developed as a secure, modular business-management platform capable of supporting internal teams and customer-facing services from a shared foundation.

The Profile Mfg inventory suite would operate as a collection of business modules within that platform. Login 2.0 would manage shared concerns across the application, while the inventory suite would manage the customer-specific operational data and workflows described in this document.

### 5.2 Shared Platform Capabilities

- **Secure authentication**
  - **Platform capability:** Password protection, multifactor authentication, recovery codes, hardened sessions, recent-authentication checks, elevated-action verification, trusted devices, and future passkey, OAuth, and single sign-on options.
  - **Inventory-suite application:** Protects inventory, production, administration, and other sensitive modules without creating a separate login system.

- **User and access management**
  - **Platform capability:** Centralized users, profiles, invitations, activation, roles, permissions, groups, access policies, elevated access, and periodic access reviews.
  - **Inventory-suite application:** Provides controlled access for administrators, order entry, inventory, production, maintenance, purchasing, shipping, management, and future customer users.

- **Responsive web and mobile use**
  - **Platform capability:** An accessible browser experience for desktop, tablet, and mobile screens.
  - **Inventory-suite application:** Supports office users, production-floor tablets, mobile scanning, maintenance access, and warehouse workflows.

- **Modular dashboards and applications**
  - **Platform capability:** Configurable widgets, personalized layouts, and independently enabled business modules.
  - **Inventory-suite application:** Allows Profile Mfg to introduce inventory, production, purchasing, maintenance, reporting, and portal capabilities in phases.

- **Reporting and operational visibility**
  - **Platform capability:** Reporting, secure exports, audit trails, error logs, health information, security events, and administrative monitoring.
  - **Inventory-suite application:** Supplies shared report presentation, export controls, monitoring, and audit infrastructure.

- **Notifications and communications**
  - **Platform capability:** In-application and real-time notifications, email delivery, communication preferences, security alerts, and configurable sender accounts.
  - **Inventory-suite application:** Supports inventory alerts, maintenance reminders, material shortages, shipment notifications, and scheduled report delivery.

- **Account self-service and shared workspace**
  - **Platform capability:** Personal profiles, security settings, preferences, account management, shared navigation, and a centralized documentation vault.
  - **Inventory-suite application:** Gives users one workspace for business modules, preferences, documentation, and account management.

- **Customer and public portals**
  - **Platform capability:** Customer login, invitations, self-enrollment, company-based access, public module content, OAuth login, and configurable customer policies.
  - **Inventory-suite application:** Creates a future path for customer order visibility, shipment records, documents, PPAP information, and other approved services.

- **Websites, calendars, and events**
  - **Platform capability:** Website publishing, calendars, events, and future booking or registration workflows.
  - **Inventory-suite application:** Provides optional shared calendar and event capabilities without making them part of the inventory module itself.

- **Integrations and automation**
  - **Platform capability:** APIs, webhooks, background jobs, scheduled tasks, service accounts, Microsoft Graph email integration, and future external-system connections.
  - **Inventory-suite application:** Provides the foundation for report scheduling, notifications, equipment or scanner integrations, data exchange, and future accounting or business-system connections.

- **Platform and release management**
  - **Platform capability:** Organization environment setup, domains, module and feature policies, support visibility, health monitoring, versioned releases, and rollback safeguards.
  - **Inventory-suite application:** Allows the Profile Mfg environment and enabled modules to be managed as a controlled deployment.

- **Security, privacy, and reliability**
  - **Platform capability:** Audit logging, monitoring, data protection, credential handling, backup and recovery planning, deployment safeguards, and critical-function verification.
  - **Inventory-suite application:** Provides a consistent operational and security baseline for all inventory-suite modules.

### 5.3 Inventory-Suite Responsibilities

The inventory suite would remain responsible for Profile Mfg's specific business records, rules, calculations, and workflows, including:

- Customers and customer-specific operational information
- Internal parts, customer parts, components, assemblies, and raw materials
- Customer orders, production work orders, and production runs
- Serialized boxes, lots, quantities, and inventory movements
- WIP, warehouse locations, and subcontractor inventory
- Production lines, routings, equipment, tooling, and maintenance
- Vendors, purchasing, material allocations, and reorder planning
- Shipments, shipment contents, photographs, and fulfillment
- PPAP and related operational or quality records
- Manufacturing calculations such as yield, waste, scrap, efficiency, and cost
- Inventory, production, purchasing, maintenance, and shipping reports

Login 2.0 would provide the reusable services around these records, but the inventory modules would define their meaning and enforce the corresponding business rules.

### 5.4 Proposed Platform Integration

The inventory suite could use Login 2.0 services for:

- Authentication and user sessions
- Organization environment and module configuration
- Role and permission enforcement
- Dashboard widgets and navigation
- Responsive page layouts
- Audit-event storage
- In-application and email notifications
- Scheduled and background work
- Secure exports
- Document and attachment storage
- API and webhook integration
- Error, health, and security monitoring
- Controlled releases and rollback

This boundary should be maintained during requirements and estimating so shared platform capabilities are not counted as separate custom inventory features. Inventory-specific configuration, permissions, dashboards, notifications, and reports will still require design and implementation within the suite.

---

## 6. Proposed Future-System Capabilities

### 6.1 Part Engineering and Material Standards

The part master could be expanded to include:

- Net finished-part weight
- Raw-material specification
- Standard raw-material input per piece or production run
- Expected process yield
- Expected setup or startup waste
- Standard cutoff, trim, saw-kerf, or extrusion-tail loss
- Revision-controlled drawings and documents
- Required tooling or dies
- Standard routing
- Standard labor and production rates
- Packaging requirements

This would allow the system to support material planning, efficiency measurement, and more accurate production estimates.

### 6.2 Waste, Scrap, and Yield

Planned process loss and actual production loss should be tracked separately.

The future system could distinguish:

- Expected setup or startup loss
- Expected cutoff, trim, kerf, or extrusion loss
- Actual setup scrap
- Extrusion or dimensional defects
- Quality rejections
- Dropped or damaged parts
- Subcontractor rejections
- Recoverable or recyclable material
- Discarded material
- Material returned to inventory

Potential calculations include:

- **Good-product weight:** accepted pieces multiplied by net part weight
- **Material consumed:** material issued minus unused material returned
- **Actual yield:** good-product weight divided by material consumed
- **Efficiency variance:** actual yield compared with the expected standard

Quality failures should be recorded as actual scrap events rather than automatically included in a part's planned waste allowance. This preserves visibility into preventable process loss.

The system may also need to support raw-material units such as:

- Pounds
- Feet
- Pieces
- Bundles
- Coils
- Billets
- Tons

Controlled units and conversions will be necessary where material requirements cannot be calculated from weight alone.

### 6.3 Parts, Components, and Assemblies

A future item master could classify records as:

- Raw material
- Purchased component
- Manufactured component
- Finished part
- Assembly
- Packaging material
- Production consumable
- Tooling
- Maintenance spare

Customer part numbers can continue to identify the finished item from the customer's perspective. Profile Mfg should also maintain an internal item or assembly number so assemblies can be controlled independently of customer naming.

Assemblies could use revision-controlled bills of material that define:

- Internal manufactured components
- Purchased third-party components
- Springs and other assembly materials
- Packaging
- Component quantities
- Effective dates
- Assembly revision
- Subcontracted services or operations

### 6.4 Customer Orders, Work Orders, and Production Runs

The future system could separate three related concepts:

1. **Customer order:** What the customer requested.
2. **Production work order:** What Profile Mfg plans to manufacture.
3. **Production run:** What was actually produced on a line during a period of time.

A production work order could include:

- Customer-order relationship
- Part or assembly
- Planned quantity
- Completed quantity
- Accepted quantity
- Scrapped quantity
- Remaining quantity
- Priority
- Planned start and completion dates
- Current operation
- Current location
- Production status

This would provide a formal basis for work-in-process tracking and production-floor visibility.

### 6.5 Routings and Production-Line Configurations

Because the machines and operation sequence may vary by part, the future system should distinguish:

- **Equipment asset:** A specific physical machine
- **Work center:** A production area or capability
- **Routing:** The required sequence of operations for a part
- **Line configuration:** The machines, tooling, settings, and labor assembled for a specific production run
- **Production run:** The actual execution of a work order

A routing could define:

- Operation sequence
- Compatible machines
- Required dies or tooling
- Setup requirements
- Standard setup time
- Standard production rate
- Inspection requirements
- Required labor
- Internal or subcontracted operation

The actual production run could record:

- Start and end time
- Equipment used
- Tooling used
- Employees assigned
- Material issued
- Accepted production
- Scrap and scrap reasons
- Downtime
- Actual production rate
- Notes and exceptions

### 6.6 Production-Floor Monitoring

A production-floor board could show:

- Current work order on each line
- Customer and part
- Planned and completed quantity
- Current operation
- Production rate
- Expected completion
- Assigned employees
- Equipment and tooling in use
- Downtime or blocked status
- Material availability
- WIP location
- Maintenance warnings

This could provide both a floor-level operating view and a management-level production summary.

### 6.7 Equipment and Maintenance

An equipment registry could maintain:

- Internal asset number
- Tracking name
- Manufacturer
- Manufacturer model or equipment ID
- Serial number
- Current location
- Equipment capability
- Operating status
- Required consumables
- Maintenance requirements
- Documentation
- Service and repair history

Maintenance plans could be triggered by:

- Calendar interval
- Runtime hours
- Production cycles
- Parts produced
- Inspection result
- Condition or operator report

The system could then report:

- Maintenance due or overdue
- Parts or cycles since last maintenance
- Maintenance cost
- Consumables and spare parts used
- Downtime
- Production performance before and after maintenance
- Equipment participation in production runs

Production counts should distinguish plant output from machine participation so a part passing through several machines is not counted multiple times as total production.

### 6.8 Labor and Production Cost

Production planning could include:

- Standard staffing requirement
- Required skill or role
- Employees assigned by line, order, date, or shift
- Planned labor hours
- Actual labor hours
- Standard cost rate
- Estimated labor cost
- Actual production labor cost

Additional estimated and actual costs could include:

- Raw material
- Purchased components
- Production consumables
- Tooling
- Maintenance
- Subcontracted operations
- Packaging

Labor and cost information should be protected by appropriate roles and permissions.

### 6.9 Physical Shop and Warehouse Locations

The future system could use a location hierarchy such as:

- Site
- Building or area
- Production line
- Rack
- Bay or row
- Shelf or bin
- Staging area
- Shipping area
- Quarantine area
- External subcontractor
- In transit

Inventory movements would identify what moved, from where, to where, when, why, and by whom.

Locations could contain:

- Raw materials
- Purchased components
- WIP boxes or lots
- Finished-goods boxes
- Packaging
- Tooling
- Consumables
- Maintenance spares

This would allow users to find material physically and understand what is available, allocated, staged, quarantined, or located outside the facility.

### 6.10 WIP and Subcontracted Operations

WIP should be treated as physical inventory associated with a work order and routing operation.

Each WIP box, lot, or quantity could identify:

- Work order
- Customer order
- Part or assembly
- Current operation
- Accepted, rejected, and remaining quantity
- Box, lot, or serial identity
- Physical location
- Previous operation
- Next operation
- In-house, staged, in-transit, or subcontractor status

A subcontractor could be represented as an external inventory location and an external routing operation. Sending material to a subcontractor would create an outbound transfer, while receiving it would record:

- Quantity returned
- Accepted quantity
- Rejected quantity
- Subcontracted service performed
- Service cost
- Receipt date
- Next required operation

This would maintain visibility and chain of custody while material is outside Profile Mfg.

### 6.11 Raw-Material Inventory and Purchasing

Raw-material inventory could track:

- Material specification
- Lot, heat, coil, billet, bundle, or other identifying information
- Unit of measure
- Quantity on hand
- Quantity allocated
- Quantity available
- Physical location
- Vendor source
- Cost
- Receipt history
- Material issued to production
- Material returned
- Material consumed
- Material scrapped

Vendor and purchasing functions could include:

- Approved vendors
- Vendor material identifiers
- Current and historical cost
- Standard lead time
- Actual lead-time history
- Minimum order quantity
- Order multiple
- Standard purchasable unit
- Purchase orders
- Expected delivery dates
- Receipts
- Vendor delivery performance

### 6.12 Material Allocation and Reorder Planning

"Spoken for" material could be represented as an allocation against released work orders.

A projected available calculation could consider:

- Current on-hand quantity
- Quantity allocated to production
- Safety stock
- Open purchase orders
- Expected receipt dates
- Work-order need dates
- Forecast or open-order demand

Reorder suggestions could consider:

- Open customer demand
- Current WIP
- Available raw material
- Standard yield and expected waste
- Vendor lead time
- Lead-time history
- Minimum order quantity
- Order multiple
- Safety stock
- Average usage
- Required production date

Initial planning could use clearly configured business rules. More predictive calculations could be added after reliable purchasing and material-consumption history has been established.

### 6.13 Shipment Management and Documentation

The future system could introduce formal shipment records containing:

- Customer
- Related customer orders
- Order lines and quantities fulfilled
- Serialized boxes included
- Ship date
- Carrier
- Tracking or bill-of-lading information
- Packing information
- Staging status
- Shipment status
- Required documentation

The photographic requirement described during planning is best treated as **Pre-Shipment Photo Documentation**. Photographs could be uploaded to the individual shipment to document pallet or package condition before it leaves the warehouse.

Separate document categories could include:

- Customer purchase-order document
- Packing list
- Bill of lading
- Pre-shipment pallet or package photographs
- Quality certificate
- PPAP document
- Proof of delivery

Attaching these records to a shipment allows multiple shipments against one customer order to remain independently documented.

The inventory suite could use Login 2.0's shared document and attachment services for storage, access control, and audit history while maintaining the business relationship between each document and its customer order, shipment, part, PPAP record, or other operational record.

### 6.14 Scanning and Mobile Technology

The future system could use a hardware-independent scanning service so different devices perform the same controlled inventory actions.

Potential technologies include:

- Existing barcode scanners
- Updated barcode labels
- QR codes
- Tablet or phone camera scanning
- NFC tags for tap-based interaction
- RFID readers for longer-range or bulk identification

Potential scan actions include:

- Receive raw material
- Issue material to a work order
- Start or complete an operation
- Create a WIP or finished-goods box
- Move inventory to a location
- Send material to a subcontractor
- Receive subcontracted material
- Record scrap
- Stage a shipment
- Ship a box
- Open an equipment record
- Record maintenance activity

QR and barcode scanning can generally use device cameras. Tap-based rack or equipment interaction is typically an NFC use case, while long-range or bulk RFID normally requires dedicated RFID hardware.

Labels and tags should identify stable system records. Business information that may change should be retrieved from the application rather than permanently encoded into the label.

Login 2.0's responsive application framework, access controls, APIs, and monitoring would provide the shared foundation for these interfaces. The inventory suite would continue to define the scan actions, validation rules, duplicate protections, and inventory effects.

### 6.15 Reporting, Alerts, and Automatic Delivery

The proposed reporting system could distinguish:

1. **On-demand reports:** A user opens or exports a current report.
2. **Scheduled subscriptions:** A report is generated and delivered on a recurring schedule.
3. **Event alerts:** A notification is triggered by an operational event or exception.

Examples include:

- A manager receives a production summary every morning.
- A user receives an inventory-status report every Monday.
- Purchasing receives a projected raw-material shortage alert.
- Maintenance receives an equipment-due notification.
- Shipping receives an alert when required photographs are missing.
- A customer-service user receives an order-completion report.

Per-user subscriptions could define:

- Report
- Filter criteria
- Schedule
- Delivery format
- Recipient list
- Time zone
- Email subject or message
- Active or inactive status

Login 2.0 could provide the shared scheduler, background-job processing, notification preferences, email delivery, sender-account configuration, secure export handling, and delivery monitoring. The inventory suite would define the business data, calculations, filters, permissions, report layouts, and events that trigger each output.

The combined system should maintain report-delivery history and identify failed deliveries.

### 6.16 Inventory-Suite Security and Operational Controls

Login 2.0 would provide the shared authentication, account security, session protection, multifactor authentication, user lifecycle, application controls, monitoring, backup planning, and deployment safeguards.

The inventory suite would add the business-specific controls needed for:

- Customer, part, order, inventory, production, purchasing, maintenance, and shipment permissions
- Separation of routine activity from elevated administrative actions
- Recent-authentication or elevated verification for sensitive actions
- Controlled inventory adjustments and shipment reversals
- Controlled bulk exports
- Access to labor, cost, customer, and security-sensitive information
- Application and module-level data separation
- Service-account and API permissions
- Audit events that identify the user, action, affected record, time, and relevant before-and-after values
- Verification of inventory calculations and critical business workflows
- Recovery testing for inventory-suite records, documents, and attachments

---

## 7. Proposed Reports and Dashboards

### 7.1 Customer Orders and Planning

- Open-order backlog
- Daily and weekly shipping schedule
- Past-due orders
- Order status and expected completion
- Customer demand by part and period
- Order fulfillment and short-shipment history

### 7.2 Production

- Production-floor line status
- Work-order progress
- Planned versus actual production
- Output by line, shift, part, and date
- Production rate and throughput
- WIP by operation and location
- Downtime and blocked work

### 7.3 Material Efficiency and Quality

- Material issued versus consumed
- Yield by part, run, line, and period
- Expected versus actual waste
- Scrap by reason and operation
- Quality rejection trends
- Recoverable and recyclable material

### 7.4 Raw Materials and Purchasing

- Raw material on hand
- Allocated or "spoken for" material
- Available material
- Projected shortages
- Projected reorder dates
- Open purchase orders
- Vendor lead-time history
- Vendor delivery performance
- Material cost history

### 7.5 Inventory and Locations

- Inventory by site, rack, bay, and bin
- Inventory by status
- WIP location
- Finished-goods box location
- Inventory aging
- Quarantined inventory
- Inventory movement history
- Inventory held at subcontractors

### 7.6 Equipment and Maintenance

- Equipment status
- Maintenance due and overdue
- Production cycles or parts since service
- Maintenance history and cost
- Equipment downtime
- Consumable and spare-parts usage
- Performance before and after maintenance

### 7.7 Labor and Cost

- Planned versus actual labor
- Staffing by line and work order
- Standard versus actual production cost
- Material, labor, maintenance, consumable, and subcontract cost
- Cost variance by part or work order

### 7.8 Shipping and Traceability

- Shipment readiness
- Boxes allocated to shipments
- Missing shipment documentation
- Pre-shipment photography status
- Shipment history
- Order-to-box-to-shipment traceability
- Raw-material-to-finished-product genealogy where required

### 7.9 Automated Reporting

- Scheduled-report subscriptions
- Event-alert definitions
- Report delivery history
- Failed or delayed deliveries

---

## 8. Proposed Phased Scope

The following phases provide one possible way to introduce the expanded capabilities while preserving business continuity.

### Phase 1: Core System Foundation

- Profile Mfg environment and inventory-module configuration
- Login 2.0 authentication and account policies
- Inventory-specific roles, permissions, and elevated actions
- Shared navigation, responsive layouts, and dashboard foundation
- Shared audit, notification, document, export, background-job, and monitoring services
- Customers and contacts
- Normalized part and item records
- Internal and customer part identifiers
- Customer order headers and order lines
- Unified inventory transactions
- Serialized boxes and scan history
- Formal shipments and shipment lines
- Physical location foundation
- Current-report parity
- Data migration and reconciliation

### Phase 2: Production Execution and WIP

- Production work orders
- Routings and operations
- Production-line configurations
- Work-in-process inventory
- Production runs
- Accepted and rejected quantities
- Scrap reasons
- Production-floor monitoring
- Mobile shop-floor scanning

### Phase 3: Raw Materials, Vendors, and Purchasing

- Raw-material item master
- Units of measure and conversions
- Bills of material
- Material issue, return, consumption, and scrap
- Vendors
- Purchase orders and receipts
- Material allocations
- Available-material calculations
- Reorder and shortage planning

### Phase 4: Equipment, Maintenance, Labor, and Subcontracting

- Equipment and asset registry
- Preventive-maintenance plans
- Maintenance work and history
- Consumables and spare parts
- Labor requirements and assignments
- Estimated and actual production cost
- Subcontracted routing operations
- External inventory and chain of custody

### Phase 5: Automation and Advanced Analytics

- Scheduled report subscriptions using Login 2.0 background services
- Event-triggered in-application and email alerts
- Personalized management dashboards and widgets
- Optional customer-portal views and document access
- Inventory-suite APIs, webhooks, and approved external integrations
- Production and material trends
- Vendor and maintenance performance
- Advanced yield and efficiency analysis
- Expanded barcode, QR, NFC, or RFID workflows

Each phase would require detailed discovery, confirmation of business rules, data design, user-interface planning, testing, training, and deployment planning.

---

## 9. Key Requirements for Further Discussion

The following decisions will shape the final system scope:

1. Should the new system remain focused on finished-goods inventory and order fulfillment, or expand into a broader manufacturing and material-planning platform?
2. How does Profile Mfg currently define expected waste, actual scrap, recoverable material, and quality loss?
3. In which units are each type of raw material purchased, stored, issued, and consumed?
4. How should customer orders translate into production work orders?
5. Can one production work order satisfy multiple customer orders?
6. Which products are assemblies, and which internal or purchased components do they contain?
7. How are dies, tooling, and machine configurations selected today?
8. Which production and equipment measurements are available automatically, and which would be entered manually?
9. What level of employee time and labor-rate information should the system maintain?
10. Which inventory must be tracked individually, by box, by lot, or only by quantity?
11. What subcontracted operations occur, and what information must accompany material sent outside the facility?
12. Which shipment documents and photographs are mandatory?
13. Which devices should be supported initially: existing scanners, tablets, phones, NFC, or dedicated RFID equipment?
14. Which reports should run automatically, and who should receive them?
15. Which historical data must be migrated from the current application?
16. Which Login 2.0 platform services will be available for the first inventory-suite release?
17. Which inventory actions require elevated verification or special approval?
18. Should customers receive portal access to orders, shipments, documents, PPAP information, or other records?
19. Which external systems should receive or provide data through APIs, webhooks, service accounts, or scheduled integrations?

---

## 10. Expected Business Outcomes

If developed in appropriate phases, the proposed system could provide:

- One connected view of customer demand, production, inventory, and shipping
- Better visibility into work in progress
- Clear physical location of raw material, WIP, and finished goods
- Improved material purchasing and shortage planning
- Measurable production yield, waste, and scrap
- Better equipment-maintenance planning
- Traceability through internal and subcontracted operations
- Stronger shipment documentation
- Reduced duplicate entry and reconciliation
- More timely reporting and alerts
- A consistent, secure workspace across desktop, tablet, and mobile use
- Reusable platform services that reduce duplicated application development
- A controlled path to customer portals and external integrations
- A scalable foundation for continued operational improvement

---

## 11. Conclusion

The current application provides a valuable operational foundation centered on customers, parts, orders, finished-goods inventory, scanning, shipping schedules, and basic reporting.

The proposed modernization would preserve those essential capabilities while connecting them to production work, raw-material planning, equipment, maintenance, locations, subcontracting, shipment documentation, and automated reporting.

Hosting the inventory suite within Login 2.0 would provide a common foundation for identity, access, dashboards, notifications, reporting services, integrations, monitoring, and controlled releases. The inventory modules could therefore remain focused on Profile Mfg's operational workflows and business rules.

The next planning step is to confirm the desired system boundary and prioritize the proposed capabilities. That discovery will determine which functions belong in the initial replacement and which should be introduced in later phases.
