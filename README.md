# Dark Horse Scheduling

*PHP-based web portal for equine facility schedule management and data tracking.*

**IMPORTANT FUNCTIONALITY NOTES**
* Do not make two distinct classes that have the exact same class-type AND exact same set of clients. This will cause one of the classes to be overridden

* Do not have multiple staff or volunteers with the same role in a single class, only one person can currently fill a given role. Make roles more specific!

## Update Log:

### Version 1.1
  *Bug fixes and minor improvements*

* Clicking on version pulls up README file and update log

* Volunteer and Horse directories are now password protected by staff credentials

* Hour entries now support decimal numbers

* Fixed permissions issue that caused reports to not work

* Previously archived 'other objects' can now be recreated through 'create object' page

* Directories now display results alphabetically, and the styles have been updated to better display large amounts of data

* Edit-class function is more stable, won't lose class data when conflicts are not properly resolved. (class data remains unchanged instead)

* New-class function is more stable, if class creation fails for any reason, you can go back to the class creation page and the data you entered will still be there

* Classes now have a display title to make it easier for users to identify distinct classes

* Clients are now presented first on the create/edit class pages

* Volunteers now have flexible roles, like staff


### Version 1.0
  *Complete Functionality*

* Complex Class Data Structure
  * Fully customizeable, infinitely extendible
    * *Class type*
    * *Arena*
    * *Horses*
    * *Tacks*
    * *Pads*
    * *Clients*
    * *Leaders*
    * *Sidewalkers*
    * *Staff Roles*

* Conflict-Free Scheduling
  * Automatic conflict detection for all people, horses, spaces, and objects
  * Automatic horse overuse detection
  * Personalized daily schedules instantly generated
    * *Staff*
    * *Volunteers*
    * *Clients*
    * *Horses*

* Volunteer Hour Tracking
  * Ease of data entry

* Staff Hour Tracking
  * Ease of data entry

* Front-Page Availability Checker
  * Instantly see if any person, horse, space, or object is free at any time.

* Directories
  * View public information for all staff, volunteers, and horses

* Reports
  * Complete access to your data
  * Generate comprehensive reports of all your organization's data
