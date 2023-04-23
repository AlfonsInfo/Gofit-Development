<script>

import { jsPDF } from "jspdf";

// Default export is a4 paper, portrait, using millimeters for units
const doc = new jsPDF({
  orientation: "landscape",
  unit: "in",
  format: [4, 2]
});
doc.text("Hello world!", 1, 1);
doc.save("two-by-four.pdf");
</script>


<template>
    <h1>Member Card</h1>
</template>
