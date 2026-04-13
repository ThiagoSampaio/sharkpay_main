ite
    // constraints along the viewport's main axis but may also have bouncing
    // scroll physics, which will allow for some scrolling effect to occur.
    // We should just use the viewportClip - the start of the overlap is at
    // double.infinity and so it is effectively meaningless.
    if (child.constraints.overlap == 0 || !child.constraints.viewportMainAxisExtent.isFinite) {
      return viewportClip;
    }

    // Adjust the clip rect for this sliver by the overlap from the previous sliver.
    double left = viewportClip.left;
    double right = viewportClip.right;
    double top = viewportClip.top;
    double bottom = viewportClip.bottom;
    final double startOfOverlap =
        child.constraints.viewportMainAxisExtent - child.constraints.remainingPaintExtent;
    final double overlapCorrection = startOfOverla