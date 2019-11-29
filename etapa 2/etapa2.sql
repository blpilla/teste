SELECT
	d.dept_name,
	CONCAT(e.first_name, ' ', e.last_name) as full_name,
	ABS(DATEDIFF(de.from_date, de.to_date)) as worked_days

FROM
	employees.dept_emp as de

INNER JOIN employees.employees as e
	ON de.emp_no = e.emp_no

INNER JOIN employees.departments as d
	 ON de.dept_no = d.dept_no

ORDER BY
	worked_days DESC;
