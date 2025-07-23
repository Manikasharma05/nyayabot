// Fetch guidance steps
async function getGuidanceSteps(issueType) {
  const response = await fetch(`api/guidance.php?issue_type=${issueType}`);
  const data = await response.json();
  console.log("Steps:", data.steps);
}

// Download FIR template
async function downloadTemplate(templateId) {
  await fetch(`api/firtemplates.php`, {
    method: "PUT",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id: templateId }),
  });
  window.location.href = `assets/templates/${templateId}.pdf`;
}

// Example usage
getGuidanceSteps("property");
downloadTemplate(1); // Assuming template ID 1 exists
