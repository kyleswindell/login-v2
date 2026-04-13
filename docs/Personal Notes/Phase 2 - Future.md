Plan for the introduction of a calendar system  that existed in the V1 App that utilized a universal 'Event' object.
- Event objects exist as a base standalone item of the calendar, as well as allowing Module instances to extend the Event object and introduce additional data and functionality that carries over to Calendar display
- Review V1 implementation of calendar with the above improvements in mind that the V2 calendar should allow events to be configured by, modified and added to with additional information/data if the event is created by/controlled by an additional module. Determine how the V1 calendar was implemented and return with any planning questions as to how we may ensure a future-proof path for calendar events.
-  An example of how the calendar events was extended is in the V1 module Events-module. This type of integration with the calendar and extension of base calendar event functionality should be modular / configurable to fit the needs of both current existing module featuresets and potentially non-planned features for post 1.0 feature additions.

Ask any follow up questions or concerns, issues, and required decisions you encounter during your planning. 

Deliverable for this should be a Calendar item that can be viewed as a month / week / day view, an 'Events' view table that displays a table of all events both past and present, counters for total events, Active events, Draft events, and other relevant displays. 

A creatable and modifiable universal event object that is extendable by modules and feature sets:

V1 filterable event types:
Events
Tasks
Projects
Invoices
Estimates
Proposals
Contracts
Customer Reminders
Expense Reminders
Lead Reminders
Estimate Reminders
Invoice Reminders
Credit Note Reminders
Proposal Reminders
Ticket Reminders

V1 Calendar Settings:
### Calendar

- [General](https://login.parasolutions.com/admin/settings?group=calendar#general) (Tab)
- [Styling](https://login.parasolutions.com/admin/settings?group=calendar#colors) (Tab)

#### General

Calendar Events Limit (Month and Week View)

---

Default View  

                 Month                 Week                 Day                 Agenda Week                 Agenda Day             

---

First Day 

                         Monday                         Tuesday                         Wednesday                         Thursday                         Friday                         Saturday                         Sunday                     

---

#### Show on Calendar

---

Hide notified reminders from calendar

Yes

 

No

---

Lead Reminders

Yes

 

No

---

Customer Reminders

Yes

 

No

---

Estimate Reminders

Yes

 

No

---

Invoice Reminders

Yes

 

No

---

Proposal Reminders

Yes

 

No

---

Expense Reminders

Yes

 

No

---

Task Reminders

Yes

 

No

---

Credit Note Reminders

Yes

 

No

Ticket Reminders

Yes

 

No

  

Invoices

Yes

 

No

---

Estimates

Yes

 

No

---

Proposals

Yes

 

No

---

Contracts

Yes

 

No

---

Tasks

Yes

 

No

---

Show only tasks assigned to the logged in staff member

Yes

 

No

---

Projects

Yes

 (Insertion of additional calendar item toggle options as Modules utilize calendar-item)

No

Notes:
"event" may not be an appropriate naming convention for calendar items. This may become confusing with the actual "Events-Module" and this was a problem in V1 with Events-Module introduction.

Potentially rename to calendar-item or other specific naming convention for the core/base Calendar item instances? Brainstorm, research and review. 

#### Styling

Invoice Color (Hex Color - Color Picker selectable object - Current selected color shown)
```
<div class="form-group" app-field-wrapper="settings[calendar_invoice_color]"><label for="settings[calendar_invoice_color]" class="control-label">Invoice Color</label><div class="input-group mbot15 colorpicker-input colorpicker-element">
    <input type="text" value="#FF6F00" name="settings[calendar_invoice_color]" id="settings[calendar_invoice_color]" class="form-control">
    <span class="input-group-addon"><i style="background-color: rgb(255, 111, 0);"></i></span>
</div></div>
```

Estimate Color

Proposal Color

Reminder Color

Contract Color

Project Color

(Insertion of additional calendar item styling options as Modules utilize calendar-item)


Note:
These two points should also be toggleable settings inside of the specific module settings options. 
(Insertion of additional calendar item styling options as Modules utilize calendar-item)
(Insertion of additional calendar item toggle options as Modules utilize calendar-item)